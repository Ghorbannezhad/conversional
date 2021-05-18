<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activated', 'appointment'];

    public const UPDATED_AT = null;
    public const CREATED_AT = null;

    //Add relation to user
    public function user(){
       return $this->belongsTo(User::class, 'user_id');
    }
}
