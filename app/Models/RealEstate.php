<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class RealEstate extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'status',
        'address',
        'bank_account',
        'bank_name',
        'email',
        'rnc',
        'contact_person',
        'contact_phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

     /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo_url',
    ];

    /**
     * Get the URL of the payment's voucher.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl('logo', 'thumb')
        ? $this->getFirstMediaUrl('logo', 'thumb')
        : null;
    }

    /**
     * Relation between a real estate and its brokers
     */
    public function brokers(): HasMany
    {
        return $this->hasMany(Broker::class, 'real_estate_id', 'id');
    }
}
