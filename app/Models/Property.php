<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    /**
     * Relation between a property and its brokers
     */
    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class);
    }

    /**
     * Relation between a property and its owner
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Relation between a property and its owner
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
