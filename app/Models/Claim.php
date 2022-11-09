<?php

namespace App\Models;

use App\Enums\ClaimStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Claim extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'property_id',
        'description',
        'amount_to_claim',
        'insurance_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => ClaimStatus::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'first_evidence_url',
    ];

    /**
     * Get the URL of the payment's voucher.
     *
     * @return string
     */
    public function getFirstEvidenceUrlAttribute()
    {
        return $this->getFirstMediaUrl('evidence', 'thumb')
        ? $this->getFirstMediaUrl('evidence', 'thumb')
        : null;
    }

    /**
     * Relation between a claim and its user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation between a claim and a property
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
