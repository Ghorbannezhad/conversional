<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $appends = ['type_text'];

    const REGISTERED = 1;
    const ACTIVATION = 2;
    const APPOINTMENT = 3;
    const CREATED_TO_ACTIVATED = 4;
    const CREATED_TO_APPOINTMENT = 5;
    const ACTIVATED_TO_APPOINTMENT = 6;

    //Change type to constant name
    public function getTypeTextAttribute(){
        switch ($this->attributes['type']){
            case self::REGISTERED:
                return trans('messages.registered_type');
            case self::ACTIVATION:
                return trans('messages.activation_type');
            case self::APPOINTMENT:
                return trans('messages.appointment_type');
            case self::CREATED_TO_ACTIVATED:
                return trans('messages.created_to_activated');
            case self::CREATED_TO_APPOINTMENT:
                return trans('messages.created_to_appointment');
            case self::ACTIVATED_TO_APPOINTMENT:
                return trans('messages.activated_to_appointment');
            default:
                return '';
        }
    }

}
