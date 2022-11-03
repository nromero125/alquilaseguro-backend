<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory;

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
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
