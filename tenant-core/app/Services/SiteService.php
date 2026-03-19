<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\Module;
use App\Models\CompanySettings;
use App\Models\User;

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

    public function getIdBySlug($slug, $company_id){
        $modulo = CompanyModule::find(12);
        dd($modulo->settings);

        return CompanyModule::where('user_id', $company_id)
        ->where('settings', 'like', '%"slug":"' . $slug . '"%')
        ->where('is_active', true)
        ->value('id');
    }

    public function getModuleConfig($module_id){
        return CompanyModule::where('id', $module_id)->value('settings');
    }


    public function getCompanyIdByName($company_name){
        return User::where('name', $company_name)->value('id');
    }
}


