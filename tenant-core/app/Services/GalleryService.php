<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\Gallery;

class GalleryService
{
    
    public function isGalleryActive($module_id){
            if (!is_numeric($module_id)) {
                return false;
            }
        $haveModel = CompanyModule::where('id', $module_id)
                        ->where('is_active', true)
                        ->firstOrFail();
        
        $settings = json_decode($haveModel->settings);
        return $haveModel->user_id;

    }

    public function uploadPhoto(array $data)
    {
        $file = $data['photo'];
            $path = $file->store('galleries/user_' . $data['user_id'], 'public');
            
            return \App\Models\Gallery::create([
                'user_id'     => $data['user_id'],
                'path'        => $path,
                'title'       => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'alt_text'    => $data['alt_text'] ?? null,
                'mime_type'   => $file->getClientMimeType(),
                'size'        => $file->getSize(),
            ]);
    }

}