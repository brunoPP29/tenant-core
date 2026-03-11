<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\CompanySettings;
use Illuminate\Support\Facades\Auth;

class CompanySettingsService
{
    public function create($data): CompanySettings
{
        $data = $data->all();
        // persistir no banco de dados
        return CompanySettings::updateOrCreate(
                ['company_id' => Auth::id()], // The unique constraint to search for
                ['settings' => $data]         // The values to update or set on creation
            );
    }
}