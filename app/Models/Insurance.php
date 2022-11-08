<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Insurance extends Model implements HasMedia
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
        'rnc',
        'contact_person',
        'contact_phone',
        'address',
        'bank_account',
        'bank_name'
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
}
