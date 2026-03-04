<?php

namespace App\Services;

use App\Models\CompanyModule;
use Illuminate\Support\Facades\Auth;

class CompanyModuleService
{
    public function create($data): CompanyModule
{
        $data = $data->all();
        // persistir no banco de dados
        return CompanyModule::create([
            'user_id' => Auth::id(),
            'module_id' => $data['module_id'],
            'settings' => json_encode(collect($data)->except(['_token', '_method', 'module_id'])->all()),
            'activated_at' => now()->toDateTimeString(),
            'is_active' => true,
        ]);
    }
}