<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_core',
        'is_active',
        'file_path',
        'default_settings',
    ];

    protected $casts = [
        'is_core' => 'boolean',
        'default_settings' => 'array',
    ];
}
