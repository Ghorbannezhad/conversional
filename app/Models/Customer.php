<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'email'];

    //Add relation to user
    public function users(){
        $this->hasMany(User::class, 'customer_id');
    }
}
