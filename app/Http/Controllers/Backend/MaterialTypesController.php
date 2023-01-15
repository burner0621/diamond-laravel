<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialTypeStoreRequest;
use App\Models\Material;
use App\Models\MaterialType;

class MaterialTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material_types = MaterialType::orderBy('id', 'DESC')
            ->with('material')
            ->get();

        return view('backend.material_types.list', compact(
            'material_types'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrMaterials = Material::pluck('name', 'id')
            ->toArray();

        return view('backend.material_types.create', compact(
            'arrMaterials'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialTypeStoreRequest $request)
    {
        $data = $request->input();
        MaterialType::create($data);
        
        return redirect()->route('backend.material_types.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialType $material_type)
    {
        $arrMaterials = Material::pluck('name', 'id')
            ->toArray();

        return view('backend.material_types.edit', compact(
            'material_type', 'arrMaterials'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialType $material_type, MaterialTypeStoreRequest $request)
    {
        $data = $request->input();
        $material_type->update($data);

        return redirect()->route('backend.material_types.list');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialType $material_type)
    {
        $material_type->delete();
        return redirect()->route('backend.material_types.list');
    }

}
