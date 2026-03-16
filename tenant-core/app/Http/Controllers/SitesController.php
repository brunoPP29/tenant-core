<?php

namespace App\Http\Controllers;

use App\Models\CompanyModule;
use App\Models\User;
use App\Services\SiteService;
use Faker\Provider\Company;
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
    public function show(string $company_name, string $slug, SiteService $service)
    {
    $user = User::where('name', $company_name)->firstOrFail();

    $module = $service->getModule($slug, $user);

    if (!$module) abort(404);

    $config = is_array($module->settings) ? $module->settings : json_decode($module->settings, true);
    if (is_string($config)) $config = json_decode($config, true);

    $settings = $service->getCompanySettings($user->id);
    
    $company = [
        'name' => $user->name,
        'display_name' => $user->display_name ?? $user->name,
        'bio' => $user->description ?? 'Portfólio de fotografias e registros visuais.',
        'avatar' => $user->profile_photo_url ?? null,
    ];

    $items = []; 

    return view($slug . '.index', [
        'config' => $config,
        'appearance' => $settings['appearance'],
        'company' => $company,
        'items' => $items,
        'total_count' => count($items)
    ]);
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
