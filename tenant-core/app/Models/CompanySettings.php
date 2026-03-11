<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    protected $fillable = [
        'company_id',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }

    public function getSetting($key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    public function setSetting($key, $value): void
    {
        $settings = $this->settings ?? [];

        data_set($settings, $key, $value);

        $this->settings = $settings;
        $this->save();
    }

    public const DEFAULT_SETTINGS = [

        'appearance' => [
            'theme' => 'dark',          // light | dark |
            'primary_color' => '#2563eb',
            'secondary_color' => '#64748b',
            'font_family' => 'Inter',
            'font_size' => 'normal',      // small | normal | large
            'border_radius' => 'md'
        ],

        'localization' => [
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i'
        ],

        'system' => [
            'maintenance_mode' => false
        ]

    ];
}
