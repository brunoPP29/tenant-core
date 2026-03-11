<?php

namespace App\Http\Controllers;

use App\Models\CompanySettings;
use App\Services\CompanySettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanySettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record = CompanySettings::where('company_id', Auth::id())->first();

            if ($record) {
                
                $data = is_array($record->settings) ? $record->settings : json_decode($record->settings, true);
                
                $settings = array_replace_recursive(CompanySettings::DEFAULT_SETTINGS, $data);
                
                
                }else{
                    $settings = CompanySettings::DEFAULT_SETTINGS;
                    }
                return view('modules_company.editSettings', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CompanySettingsService $service)
    {
        try {
            $service->create($request->request);
                    return redirect()
                        ->route('settingsCompany.index')
                        ->with('success', 'Configurações alteradas com sucesso!');
        } catch (\Throwable $e) {
            dd($e);
                return back()
                    ->withInput()
                    ->with('error', 'Erro ao alterar configurações.');
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
