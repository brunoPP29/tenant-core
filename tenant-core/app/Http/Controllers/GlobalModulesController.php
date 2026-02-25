<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Models\Module;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class GlobalModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::all();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuleRequest $request, ModuleService $service)
    {
        
            try {
                $service->create(
                    $request->validated(),
                    $request->file('module_file')
                );

                return redirect()
                    ->route('modules.create')
                    ->with('success', 'Módulo criado com sucesso!');

            } catch (\Throwable $e) {

                return back()
                    ->withInput()
                    ->with('error', 'Erro ao criar módulo.');
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
        try{
            Module::destroy($id);

                return redirect()
                    ->route('modules.index')
                    ->with('success', 'Módulo deletado com sucesso!');
            }catch(\Throwable $e){
                return back()
                    ->withInput()
                    ->with('error', 'Erro ao deletar módulo.');
    }
    }


    //activate or deactivate modules by admin

    public function activate(Request $request){
        try{
            Module::where('id', $request->id)
                ->update([
                    'is_active' => true
                ]);

                return redirect()
                    ->route('modules.index')
                    ->with('success', 'Módulo atualizado com sucesso!');
            }catch(\Throwable $e){
                return back()
                    ->withInput()
                    ->with('error', 'Erro ao atualizar módulo.');
    }
        
    } 

    public function deactivate(Request $request){
        try{
            Module::where('id', $request->id)
                ->update([
                    'is_active' => false
                ]);

                return redirect()
                    ->route('modules.index')
                    ->with('success', 'Módulo atualizado com sucesso!');
            }catch(\Throwable $e){
                return back()
                    ->withInput()
                    ->with('error', 'Erro ao atualizar módulo.');
    }
    }
}

