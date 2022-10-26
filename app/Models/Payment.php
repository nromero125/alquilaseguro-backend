<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['amount', 'payment_type', 'property_id', 'paid_at', 'is_late', 'status', 'tenant_id'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'voucher_url',
    ];

    /**
     * Get the URL of the payment's voucher.
     *
     * @return string
     */
    public function getVoucherUrlAttribute()
    {
        return $this->getFirstMediaUrl('evidence', 'thumb')
        ? $this->getFirstMediaUrl('evidence', 'thumb')
        : null;
    }
}
