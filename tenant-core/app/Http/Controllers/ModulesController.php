<?php

namespace App\Http\Controllers;

use App\Models\CompanyModule;
use App\Models\Module;
use Faker\Provider\Company;
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
    public function store(Request $request)
    {
        //
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
    public function destroy(Module $modules)
    {
        //
    }

    public function activate(string $id){
        $module_id = $id;
        $existing = CompanyModule::where('module_id', $module_id)
                            ->first();
        if ($existing) {
            CompanyModule::where('module_id', $module_id)
                        ->update(['is_active' => true]);
        }else{
            //vai ser primeira vez ativando
            $defaultSettings = Module::where('id', $module_id)
                ->value('default_settings');

            return view('modules_company.active', compact('defaultSettings'));
        }
    }

    public function deactive(string $id){
            $module_id = $id;
            CompanyModule::where('module_id', $module_id)
                        ->update(['is_active' => false]);
            return redirect()
                    ->route('modules.index')
                    ->with('success', 'Módulo desativado com sucesso!');
    }
}
