<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\SiteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(string $id, ProductService $service)
    {
        $companyIdCheck = $service->isModuleActive($id);
        if ($companyIdCheck) {
            $products = Product::where('user_id', $companyIdCheck)->get();
            return view('products.manage', compact('companyIdCheck', 'products', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(ProductRequest $request, ProductService $service): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            $service->createProduct($data);
            return back()->with('success', 'Produto adicionado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao salvar: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, string $id, ProductService $service)
    {
        try {
            $service->updateProduct($id, $request->validated());
            return redirect()->route('modulesCompany.productsManage', ['id' => $request->module_id])
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    public function destroy(string $id, ProductService $service)
    {
        try {
            $service->deleteProduct($id);
            return back()->with('success', 'Produto removido com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover: ' . $e->getMessage());
        }
    }

    public function viewCatalog(string $company_name, SiteService $siteService)
    {
        $company_id = $siteService->getCompanyIdByName($company_name);
        $company_settings = $siteService->getCompanySettings($company_id);
        $module_id = $siteService->getIdBySlug('catalog', $company_id);
        $configs_module = $siteService->getModuleConfig($module_id);

        $products = Product::where('user_id', $company_id)->get();

        return view('products.index', compact('products', 'company_settings', 'configs_module', 'company_name'));
    }
}
