<?php

namespace App\Models;

use App\Enums\IdentificationTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tenant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'phone_number',
        'status',
        'identification',
        'firstname',
        'lastname',
        'address',
        'bank_name',
        'bank_account',
        'user_id',
        'contract_start_date',
        'contract_end_date',
        'identification_type'
    ];

    protected $casts = [
        'identification_type' => IdentificationTypes::class
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
