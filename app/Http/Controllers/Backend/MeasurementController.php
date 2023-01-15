<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductMeasurementRelationship;
use App\Models\ProductMeasurement;
use Exception;

class MeasurementController extends Controller
{
    //
    public function index()
    {
        $measurements = ProductMeasurement::all();

        return view('backend.measurements.list', compact('measurements'));
    }

    public function create()
    {
        return view('backend.measurements.create');
    }

    public function store(Request $request)
    {
        $measurement = new ProductMeasurement;

        $measurement->name = $request->name;
        $measurement->units = $request->units;

        $measurement->save();

        return redirect()->route('backend.measurements.create');
    }

    public function edit($id)
    {
        $measurement = ProductMeasurement::find($id);

        return view('backend.measurements.edit', compact('measurement'));
    }

    public function update(Request $request)
    {
        $measurement = ProductMeasurement::find($request->id);

        $measurement->update([
            'name' => $request->name,
            'units' => $request->units
        ]);

        return redirect()->back();
    }

    public function delete($id)
    {
        try {
            ProductMeasurement::find($id)->delete();
            return redirect()->route('backend.measurements.list');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
