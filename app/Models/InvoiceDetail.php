<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable = ['invoice_id', 'user_id', 'session_id', 'type', 'price', 'activated_count', 'appointment_count'];
    protected $hidden = ['deleted_at'];

    public const UPDATED_AT =  null;

    const REGISTERED_TYPE = 1;
    const ACTIVATION_TYPE = 2;
    const APPOINTMENT_TYPE = 3;
    const CREATED_TO_ACTIVATED_TYPE = 4;
    const CREATED_TO_APPOINTMENT_TYPE = 5;
    const ACTIVATED_TO_APPOINTMENT_TYPE = 6;

    //Add invoice relation
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    //Add relation to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    //Change type to constant name
    public function getTypeAttribute(){
        switch ($this->attributes['type']){
            case self::REGISTERED_TYPE:
                return trans('messages.registered_type');
            case self::ACTIVATION_TYPE:
                return trans('messages.activation_type');
            case self::APPOINTMENT_TYPE:
                return trans('messages.appointment_type');
            case self::CREATED_TO_ACTIVATED_TYPE:
                return trans('messages.created_to_activated');
            case self::CREATED_TO_APPOINTMENT_TYPE:
                return trans('messages.created_to_appointment');
            case self::ACTIVATED_TO_APPOINTMENT_TYPE:
                return trans('messages.activated_to_appointment');
            default:
                return '';
        }
    }

}
