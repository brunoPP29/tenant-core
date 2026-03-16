<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\Module;
use App\Models\CompanySettings;

class SiteService
{
    public function getActiveModules($user_id)
    {
        return CompanyModule::where('user_id', $user_id)
                            ->where('is_active', true)
                            ->pluck('module_id')
                            ->toArray();
    }

    public function getModuleData($module_id){
        return Module::where('id', $module_id)
        ->select([
            'name', 
            'default_settings->infos->slug as slug' 
        ])
        ->first();
    }

    public function getCompanySettings($user_id){
        return CompanySettings::where('company_id', $user_id)->value('settings');
    }

    public function getModule($slug, $user){
        return CompanyModule::where('user_id', $user->id)
        ->where('is_active', true)
        ->get()
        ->first(function ($item) use ($slug) {
            $settings = is_array($item->settings) ? $item->settings : json_decode($item->settings, true);
            if (is_string($settings)) $settings = json_decode($settings, true);
            return ($settings['slug'] ?? null) === $slug;
        });
    }
}


