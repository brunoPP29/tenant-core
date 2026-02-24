<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_core',
        'file_path',
        'config',
    ];

    protected $casts = [
        'is_core' => 'boolean',
        'config' => 'array',
    ];
}
