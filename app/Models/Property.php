<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_id',
        'broker_id',
        'tenant_id',
        'real_estates_id',
        'payment_due_date',
        'description',
        'code',
        'address',
        'status',
        'monthly_payment',
    ];
}
