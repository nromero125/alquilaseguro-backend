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

}
