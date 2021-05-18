<?php

namespace App\Http\Controllers\API;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Price;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends ApiController
{
    /**
     * Create invoice
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'from' => ['date', 'required'],
            'to'   => ['date', 'required', 'after:from'],
            'customer_id' => ['integer', 'required']
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(self::HTTP_UNPROCESSABLE_ENTITY, static::MESSAGE_VALIDATION_ERROR, null, $validator->errors());
        }
        else {

            //check duplicate invoice and no gap between previous invoice and this one
            //I think gap between invoices make trouble in accounting assumptions
            //todo: If there is no last invoice, we can force first invoice to start from customer registration date
            $last_invoice = Invoice::where('customer_id', $request->customer_id)->orderBy('to', 'desc')->first();
            if(!empty($last_invoice)) {
                $accepted_from = Carbon::createFromFormat('Y-m-d', $last_invoice->to)->addDay(1)->format('Y-m-d');
                //Minimum 1 day for invoice. just an assumption.
                //todo: Need to set minimum in config file
                $accepted_to = Carbon::createFromFormat('Y-m-d', $last_invoice->to)->addDay(2)->format('Y-m-d');


                if ($request->from != $accepted_from || $request->to < $accepted_to) {
                    $data = [
                        'last_invoice_from' => $last_invoice->from,
                        'last_invoice_to'   => $last_invoice->to,
                        'accepted_from'     => $accepted_from,
                    ];
                    return $this->jsonResponse(self::HTTP_UNPROCESSABLE_ENTITY, trans('messages.time_overlap'), $data);

                }
            }

            $new_users = User::where('customer_id', $request->customer_id)
                ->whereNull('state')
                ->where('created_at' ,'>=', $request->from)->where('created_at', '<=', $request->to)
                ->with(['sessions' => function ($query) use ($request){
                    $query ->where(function ($query) use ($request){
                        $query->where('activated', '>=', $request->from)
                            ->where('activated', '<=', $request->to);
                    });
                    $query->orWhere(function($query) use ($request){
                        $query ->where('appointment', '>=', $request->from)
                            ->where('appointment', '<=', $request->to);
                    });
                }])->get();


            $prev_users = User::where('customer_id', $request->customer_id)
                ->where('created_at', '<', $request->from)->where('state', '<', User::APPOINTMENT_STATE)
                ->whereHas('sessions')
                ->with(['sessions' => function ($query) use ($request){
                    $query ->where(function ($query) use ($request){
                        $query->where('activated', '>=', $request->from)
                            ->where('activated', '<=', $request->to);
                    });
                    $query->orWhere(function($query) use ($request){
                        $query ->where('appointment', '>=', $request->from)
                            ->where('appointment', '<=', $request->to);
                    });
                }])->get();

            $users = $new_users->merge($prev_users);

            try{
                DB::beginTransaction();

                //Create invoice
                $invoice = Invoice::firstOrCreate([
                    'customer_id' => $request->customer_id,
                    'from'  => $request->from,
                    'to'    => $request->to,
                ]);

                $total_price = 0;
                $total_activated = 0;
                $total_appointment = 0;
                $total_registered = 0;
                $activated_count = 0;
                $appointment_count = 0;
                $users_list = [];

                $prices = Price::get();
                if($users->count() > 0){
                    foreach ($users as $user){
                        $prev_state = $user->state;
                        //I count unique appointment, activated and register in invoice, and all appointment and activation sessions for each user.
                        if($user->sessions->count() > 0){
                            $appointment_count = ($user->sessions)->where('appointment', '!=', null)->count();
                            $activated_count = ($user->sessions)->where('activated', '!=', null)->where('appointment', null)->count();
                            if($appointment_count > 0){
                                $total_appointment++;
                                $user->state = User::APPOINTMENT_STATE;
                            }else{
                                $total_activated++;
                                $user->state = User::ACTIVATED_STATE;
                            }

                        }else{
                            $total_registered++;
                            $user->state = User::CREATED_STATE;
                        }

                        if($user->state <= $prev_state){
                            $total_appointment--;
                            $total_activated--;
                            $total_registered--;
                            continue;
                        }

                        $user->save();
                        $type = $user->state;

                        if($prev_state != null){
                            if($prev_state == User::CREATED_STATE and $user->state == User::ACTIVATED_STATE){
                                $type = User::CREATED_TO_ACTIVATED_STATE;
                            }elseif($prev_state == User::CREATED_STATE and $user->state == User::APPOINTMENT_STATE){
                                $type = User::CREATED_TO_APPOINTMENT_STATE;
                            }elseif($prev_state == User::ACTIVATED_STATE and $user->state == User::APPOINTMENT_STATE){
                                $type = User::ACTIVATED_TO_APPOINTMENT_STATE;
                            }
                        }

                        $price = $prices->where('type', $type)->first();
                        $total_price+= $price->price;

                        InvoiceDetail::create([
                            'invoice_id'            => $invoice->id,
                            'user_id'               => $user->id,
                            'type'                  => $type,
                            'price'                 => $price->price,
                            'activated_count'       => $activated_count,
                            'appointment_count'     => $appointment_count,
                        ]);
                    }
                }
                $invoice->total_price = $total_price;
                $invoice->total_appointment = $total_appointment;
                $invoice->total_registered = $total_registered;
                $invoice->total_activated = $total_activated;
                $invoice->save();

                $data = [
                    'invoice_id'  => $invoice->id
                ];

                DB::commit();
                return $this->jsonResponse(self::HTTP_CREATED, static::MESSAGE_SUCCESS, $data);
            }catch (\Exception $exception){
                info($exception);
                DB::rollBack();
                return $this->jsonResponse(self::HTTP_ERROR, static::MESSAGE_UNKNOWN_ERROR, null);

            }
        }
    }

    public function detail(Request $request):JsonResponse{

        $invoice = Invoice::where('id', $request->id)->with('customer')->with('invoiceDetails.user')->first();
        $prices = Price::get();

        if(!empty($invoice)){
            $data = [
                'invoice'  => $invoice,
                'prices'    => $prices
            ];

            return $this->jsonResponse(self::HTTP_OK, static::MESSAGE_SUCCESS, $data);

        }else{
            return $this->jsonResponse(self::HTTP_NOT_FOUND, static::MESSAGE_NOT_FOUND, null);

        }
    }
}