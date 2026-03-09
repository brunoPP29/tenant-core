<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
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
}
