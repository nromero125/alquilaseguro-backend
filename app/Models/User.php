<?php

namespace App\Models;

use App\Enums\UserTypes;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, mixed>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_type' => UserTypes::class,
        'status' => 'boolean',
    ];

    /**
     * Relation between an user and its broker data
     */
    public function broker(): HasOne
    {
        return $this->hasOne(Broker::class, 'user_id', 'id');
    }

    /**
     * Relation between an user and its owner data
     */
    public function owner(): HasOne
    {
        return $this->hasOne(Owner::class, 'user_id', 'id');
    }

    /**
     * Relation between an user and its claims
     */
    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class, 'user_id', 'id');
    }

    /**
     * Relation between an user and its claims
     */
    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class, 'user_id', 'id');
    }

    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '@alquilaseguro.com');
    }

    public function insurer(): HasOne
    {
        return $this->hasOne(Insurer::class, 'user_id', 'id');
    }
}
