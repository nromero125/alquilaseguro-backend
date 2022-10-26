<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'broker_id',
        'tenant_id',
        'real_estate_id',
        'payment_due_date',
        'description',
        'code',
        'address',
        'status',
        'monthly_payment',
    ];

    /**
     * Relation between a property and its claims
     */
    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class, 'property_id', 'id');
    }
}
