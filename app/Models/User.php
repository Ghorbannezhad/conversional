<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $hidden = ['updated_at', 'state'];

    protected $fillable = ['email', 'customer_id'];

    const CREATED_STATE = 1;
    const ACTIVATED_STATE = 2;
    const APPOINTMENT_STATE = 3;
    const CREATED_TO_ACTIVATED_STATE = 4;
    const CREATED_TO_APPOINTMENT_STATE = 5;
    const ACTIVATED_TO_APPOINTMENT_STATE = 6;

    //Add relation to customer
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    //Add relation to session
    public function sessions(){
        return $this->hasMany(Session::class, 'user_id');
    }

}
