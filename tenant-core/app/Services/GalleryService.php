<?php

namespace App\Services;

use App\Models\CompanyModule;

class GalleryService
{
    
    public function isGalleryActive($module_id){
        $haveModel = CompanyModule::where('id', $module_id)
                        ->where('is_active', true)
                        ->firstOrFail();
        $settings = json_decode($haveModel->settings);
        return $settings->slug === 'gallery';

    }

}