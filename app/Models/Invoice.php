<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends Model
{
    use SoftDeletes, CascadeSoftDeletes ;

    protected $fillable = ['customer_id', 'from', 'to'];

    protected $hidden = ['deleted_at'];

    protected $appends = ['total_event'];

    //It will soft delete invoice detail after invoice soft delete
    protected $cascadeDeletes = ['invoiceDetail'];

    public const UPDATED_AT = null;

    const FAILED_STATUS = 1;


    public function getTotalEventAttribute(){
        $total = $this->attributes['total_appointment'] +  $this->attributes['total_activated'] + $this->attributes['total_registered'];
        return $total;
    }

    //Add relation to customer
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    //Add relation to Invoice detail
    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }


}
