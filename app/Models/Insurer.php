<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
