<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\IdentificationTypes;

class Insurer extends Model
{
    use HasFactory;

    protected $fillable = [
        'insurance_id',
        'user_id',
        'phone_number',
        'status',
        'firstname',
        'lastname',
        'phone_number',
        'identification',
        'address',
        'bank_name',
        'bank_account',
        'identification_type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'identification_type' => IdentificationTypes::class,
    ];

    public function insurance(): BelongsTo
    {
        return $this->belongsTo(Insurance::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
