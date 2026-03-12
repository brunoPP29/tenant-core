<?php

namespace App\Http\Controllers;

use App\Models\CompanyModule;
use App\Models\User;
use App\Services\SiteService;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $company_name, SiteService $service)
    {
        $user_id = User::where('name', $company_name)
                        ->value('id');
        if (!$user_id) {
                abort(404);
            }

        $modules_activated = $service->getActiveModules($user_id);

        $modules_info = [];

        foreach ($modules_activated as $module_id) {
            $module = $service->getModuleData($module_id);
            
            if ($module) {
                $modules_info[] = [
                    'name' => $module->name,
                    'slug' => $module->slug
                ];
            }
        }

        $settings = $service->getCompanySettings($user_id);


        //aqui verificaria se tivesse um sistema de temas do user antes de enviar para uma view padrao com os dados dos modulos

        return view('themesHome.default', compact('modules_info', 'company_name', 'settings'));
                        
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
