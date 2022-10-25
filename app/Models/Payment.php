<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'payment_type', 'property_id', 'paid_at', 'is_late', 'status', 'tenant_id'];


    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
