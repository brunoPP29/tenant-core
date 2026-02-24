<?php

namespace App\Services;

use App\Models\Module;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ModuleService
{
    public function create(array $data, UploadedFile $file): Module
    {
        // salvar arquivo storage local
        $path = $file->store('modules');

        $json = Storage::get($path);
        $defaultSettings = json_decode($json, true);

        // persistir no banco de dados
        return Module::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'is_core' => $data['is_core'] ?? false,
            'file_path' => $path,
            'is_active' => false,
            'default_settings' => $defaultSettings,
        ]);
    }
}