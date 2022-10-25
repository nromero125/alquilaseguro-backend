<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = ['phone_number',
        'status',
        'identification',
        'firstname',
        'lastname',
        'address',
        'bank_name',
        'bank_account',
        'user_id'];


    public function property()
    {
        return $this->hasOne(Property::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
