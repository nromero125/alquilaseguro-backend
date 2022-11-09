<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'validity', 'insurance_id'
    ];


    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
