<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponStoreRequest;
use App\Models\Coupon;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->get();

        return view('backend.coupons.list', compact(
            'coupons'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request)
    {
        $data = $request->input();
        $data['name'] = strtoupper(str_replace(' ', '', $data['name']));
        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        Coupon::create($data);
        
        return redirect()->route('backend.coupons.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('backend.coupons.edit', compact(
            'coupon'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Coupon $coupon, CouponStoreRequest $request)
    {
        $data = $request->input();
        $data['name'] = strtoupper(str_replace(' ', '', $data['name']));
        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        $coupon->update($data);

        return redirect()->route('backend.coupons.list');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('backend.coupons.list');
    }

}
