<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
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
            $photos = Gallery::where('user_id', $companyIdCheck)->get();
            return view('gallery.manage', compact('companyIdCheck', 'photos', 'id'));
        } else {
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
    public function store(GalleryRequest $request, GalleryService $service): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $service->uploadPhoto($data);

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
        $photo = Gallery::where('user_id', auth()->id())->findOrFail($id);
        return view('gallery.edit', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryRequest $request, string $id, GalleryService $service)
    {
        try {
            $service->updatePhoto($id, $request->validated());

            return redirect()->route('modulesCompany.galleryManage', ['id' => $request->module_id])
                ->with('success', 'Foto atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, GalleryService $service)
    {
        try {
            $service->deletePhoto($id);
            return back()->with('success', 'Foto removida com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover: ' . $e->getMessage());
        }
    }

    public function viewGallery(string $company_name, GalleryService $service, SiteService $siteService)
    {
        //checar se gallery ta active $idCompany = $service->isGalleryActive($module_id);
        $company_id = $siteService->getCompanyIdByName($company_name);
        $company_settings = $siteService->getCompanySettings($company_id);
        $module_id = $siteService->getIdBySlug('gallery', $company_id);
        $configs_module = $siteService->getModuleConfig($module_id);

        $photos = Gallery::where('user_id', $company_id)->get();

        return view('gallery.index', compact('photos', 'company_settings', 'configs_module', 'company_name'));

    }
}
