<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModule extends Model
{
    protected $table = 'company_modules';

    protected $fillable = [
        'user_id',
        'module_id',
        'settings',
        'is_active',
        'activated_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'activated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getSetting(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    public function setSetting(string $key, $value): void
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->settings = $settings;
    }
}