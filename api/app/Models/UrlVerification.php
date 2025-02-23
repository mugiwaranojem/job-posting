<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlVerification extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = ['token', 'type', 'params', 'source_id', 'expiry'];

    protected $casts = [
        'params' => 'array',
        'expiry' => 'datetime',
    ];
}
