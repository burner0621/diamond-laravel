<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\DiamondStoreRequest;
use App\Models\MaterialTypeDiamonds;
use App\Models\MaterialType;

class DiamondsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $diamonds = MaterialTypeDiamonds::orderBy('id', 'DESC')->get();
        $diamonds = MaterialTypeDiamonds::with(['material'])
                ->leftjoin('material_types', 'material_types.id', '=', 'material_type_id')
                ->select('material_types.type', 'material_type_diamonds.*')
                ->orderBy('id', 'DESC')->get();
        return view('backend.diamonds.list', compact(
            'diamonds'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $material_types = MaterialType::where('material_id', '=', '1')->get();
        $material_id = 1;
        return view('backend.diamonds.create', compact('material_types', 'material_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiamondStoreRequest $request)
    {
        $data = $request->input();
        MaterialTypeDiamonds::create($data);
        
        return redirect()->route('backend.diamonds.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialTypeDiamonds $diamond)
    {
        $material_types = MaterialType::where('material_id', '=', '1')->get();
        $material_id = 1;
        return view('backend.diamonds.edit', compact(
            'diamond', 'material_types', 'material_id'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialTypeDiamonds $diamond, DiamondStoreRequest $request)
    {
        $data = $request->input();
        $diamond->update($data);

        return redirect()->route('backend.diamonds.list');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialTypeDiamonds $diamond)
    {
        $diamond->delete();
        return redirect()->route('backend.diamonds.list');
    }

}
