<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Http\Requests\StoreAttributeValuesRequest;



class AttributesvaluesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_attribute)
    {
        return view('backend.products.attributes.values.list',[
            'attribute' => Attribute::findOrFail($id_attribute),
            'values' => AttributeValue::where('attribute_id', $id_attribute)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeValuesRequest $request, $id_attribute)
    {
        $data = $request->input();
        
        $data['slug'] = str_replace(" ","-", strtolower($request->name));
        $data['attribute_id'] = $id_attribute;
        AttributeValue::create($data);
        return redirect()->route('backend.products.attributes.values.list', $id_attribute);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_attribute,$id)
    {
        return view('backend.products.attributes.values.edit',[
            'attribute' => Attribute::findOrFail($id_attribute),
            'value' => AttributeValue::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAttributeValuesRequest $request, $id_attribute, $id)
    {
        
        $data = $request->input();
        $data['slug'] = str_replace(" ","-", strtolower($request->name));
        $values = AttributeValue::findOrFail($id);
        $values->update($data);
        return redirect()->route('backend.products.attributes.values.list', $id_attribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_attribute, $id)
    {
        AttributeValue::findOrFail($id)->delete();
        return redirect()->route('backend.products.attributes.values.list', $id_attribute);
    }
}
