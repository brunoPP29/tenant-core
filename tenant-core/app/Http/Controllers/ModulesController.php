<?php

namespace App\Http\Controllers;

use App\Models\CompanyModule;
use App\Models\CompanySetting;
use App\Services\CompanyModuleService;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::where('is_active', true)
                    ->get();
        $companyModules = CompanyModule::all();
        return view('modules_company.index', compact('modules', 'companyModules'));
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
    public function store(Request $request, CompanyModuleService $service)
    {
            try {
                $service->create($request->request);

                    return redirect()
                        ->route('modulesCompany.index')
                        ->with('success', 'Módulo ativado com sucesso!');

            } catch (\Throwable $e) {
                return back()
                    ->withInput()
                    ->with('error', 'Erro ao ativar módulo.');
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $modules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $modules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $modules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            try{
            CompanyModule::where('module_id', $id)
                ->delete();
                return redirect()
                    ->route('modulesCompany.index')
                    ->with('success', 'Módulo resetado com sucesso!');
            }catch(\Throwable $e){
                dd($e);
                return back()
                    ->withInput()
                    ->with('error', 'Erro ao resetar módulo.');
    }
    }

    public function activate(string $id, CompanyModuleService $service){

        //check if settings company already setted

        $checkSettings = $service->isSettingsSetted();
        if (!$checkSettings) {
                return redirect()
                    ->route('modulesCompany.settingsEdit');
        }else{

        }

        $module_id = $id;
        $existing = CompanyModule::where('module_id', $module_id)
                            ->first();
        if ($existing) {
            //ja existe eh so ativar
            CompanyModule::where('module_id', $module_id)
                    ->update(['is_active' => true]);
                return redirect()
                    ->route('modulesCompany.index')
                    ->with('success', 'Módulo ativado com sucesso!');
        }else{
            //vai ser primeira vez ativando
            $defaultSettings = Module::where('id', $module_id)
                ->value('default_settings');
            return view('modules_company.active', compact('defaultSettings', 'module_id'));
        }
    }

    public function deactivate(string $id){
            $module_id = $id;
            CompanyModule::where('module_id', $module_id)
                        ->update(['is_active' => false]);
            return redirect()
                    ->route('modulesCompany.index')
                    ->with('success', 'Módulo desativado com sucesso!');
    }


}
