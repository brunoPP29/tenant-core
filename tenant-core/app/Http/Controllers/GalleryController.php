<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Services\GalleryService;
use App\Services\SiteService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id, GalleryService $service)
    {
        $companyIdCheck = $service->isGalleryActive($id);
        if ($companyIdCheck) {
            return view('gallery.manage', compact('companyIdCheck'));
        }else{
            abort(404);
        }
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
    public function store(GalleryRequest $request, GalleryService $service) : RedirectResponse
    {  
        try {
            $service->uploadPhoto($request->validated());

            return back()->with('success', 'Foto adicionada à galeria com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao salvar: ' . $e->getMessage());
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

    public function viewGallery(string $company_name, GalleryService $service, SiteService $siteService)
    {
        //checar se gallery ta active $idCompany = $service->isGalleryActive($module_id);
        $company_id = $siteService->getCompanyIdByName($company_name);
        $company_settings = $siteService->getCompanySettings($company_id);
        $module_id = $siteService->getIdBySlug('gallery', $company_id);
        $configsModule = $siteService->getModuleConfig($module_id);
        dd($company_id, $company_settings, $module_id, $configsModule);

    }
}
