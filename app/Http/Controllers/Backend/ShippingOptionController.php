<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingOptionStoreRequest;
use App\Http\Requests\ShippingOptionUpdateRequest;
use App\Models\ShippingOption;
use Illuminate\Http\Request;

class ShippingOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.shipping.index')->with('shippings', ShippingOption::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingOptionStoreRequest $request)
    {
        $shipping = new ShippingOption;

        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->price = $request->price * 100;

        if ($shipping->save()) {
            return redirect()->route('backend.shipping.index')->withErrors('The create action is success');
        } else {
            return redirect()->route('backend.shipping.index')->withErrors('The create action is failed.');
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
        return view('backend.shipping.show')->with('shipping', ShippingOption::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.shipping.edit')->with('shipping', ShippingOption::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingOptionUpdateRequest $request, $id)
    {
        $shipping = ShippingOption::find($id);

        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->price = $request->price * 100;
        
        if ($shipping->save()) {
            return redirect()->route('backend.shipping.index')->withErrors('The update action is success');
        } else {
            return redirect()->route('backend.shipping.edit', $id)->withErrors('The update action is failed.');
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
        if (ShippingOption::destroy($id)) {
            return redirect()->route('backend.shipping.index')->withErrors('The delete action is success');
        } else {
            return redirect()->route('backend.shipping.index')->withErrors('The delete action is failed');
        }
    }
}
