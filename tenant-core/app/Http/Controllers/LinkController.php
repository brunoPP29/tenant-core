<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Models\Link;
use App\Services\LinkService;
use App\Services\SiteService;
use Illuminate\Http\RedirectResponse;

class LinkController extends Controller
{
    public function index(string $id, LinkService $service)
    {
        $companyIdCheck = $service->isModuleActive($id);
        if ($companyIdCheck) {
            $links = Link::where('user_id', $companyIdCheck)->orderBy('order')->get();
            return view('links.manage', compact('companyIdCheck', 'links', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(LinkRequest $request, LinkService $service): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $service->createLink($data);
            return back()->with('success', 'Link adicionado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao salvar: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $link = Link::where('user_id', auth()->id())->findOrFail($id);
        return view('links.edit', compact('link'));
    }

    public function update(LinkRequest $request, string $id, LinkService $service)
    {
        try {
            $service->updateLink($id, $request->validated());
            return redirect()->route('modulesCompany.linksManage', ['id' => $request->module_id])
                ->with('success', 'Link atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    public function destroy(string $id, LinkService $service)
    {
        try {
            $service->deleteLink($id);
            return back()->with('success', 'Link removido com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover: ' . $e->getMessage());
        }
    }

    public function viewLinks(string $company_name, SiteService $siteService)
    {
        $company_id = $siteService->getCompanyIdByName($company_name);
        $company_settings = $siteService->getCompanySettings($company_id);
        $module_id = $siteService->getIdBySlug('links', $company_id);
        $configs_module = $siteService->getModuleConfig($module_id);

        $links = Link::where('user_id', $company_id)->orderBy('order')->get();

        return view('links.index', compact('links', 'company_settings', 'configs_module', 'company_name'));
    }
}
