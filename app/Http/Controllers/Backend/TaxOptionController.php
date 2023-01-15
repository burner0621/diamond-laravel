<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaxOptionStoreRequest;
use App\Http\Requests\TaxOptionUpdateRequest;
use App\Models\ProductsTaxOption;
use Illuminate\Http\Request;

class TaxOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.tax.index')->with('taxes', ProductsTaxOption::all());
    }

    /**
     * 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxOptionStoreRequest $request)
    {
        $tax = new ProductsTaxOption;

        $tax->price = $request->price * 100;
        $tax->name = $request->name;
        $tax->type = $request->type;

        if ($tax->save()) {
            return redirect()->route('backend.tax.index')->withErrors('The create action is success');
        } else {
            return redirect()->route('backend.tax.index')->withErrors('The create action is failed.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backend.tax.show')->with('tax', ProductsTaxOption::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.tax.edit')->with('tax', ProductsTaxOption::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaxOptionUpdateRequest $request, $id)
    {
        $tax = ProductsTaxOption::find($id);

        $tax->name = $request->name;
        $tax->price = $request->price * 100;
        $tax->type = $request->type;
        
        if ($tax->save()) {
            return redirect()->route('backend.tax.index')->withErrors('The update action is success');
        } else {
            return redirect()->route('backend.tax.edit', $id)->withErrors('The update action is failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ProductsTaxOption::destroy($id)) {
            return redirect()->route('backend.tax.index')->withErrors('The delete action is success');
        } else {
            return redirect()->route('backend.tax.index')->withErrors('The delete action is failed');
        }
    }
}
