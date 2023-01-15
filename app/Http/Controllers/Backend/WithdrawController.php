<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SellerPaymentMethod;
use App\Models\SellerWalletWithdrawal;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    //
    public function index()
    {
        SellerWalletWithdrawal::where('status', 0)->update(['status' => 1]);
        $withdraws = SellerWalletWithdrawal::with('user')->orderBy('created_at', 'desc')->get();

        return view('backend.withdraws.list', compact('withdraws'));
    }

    public function methods()
    {
        $methods = SellerPaymentMethod::orderBy('created_at', 'desc')->get();

        return view('backend.withdraws.method.index', compact('methods'));
    }

    public function methods_add_get()
    {
        return view("backend.withdraws.method.create");
    }
    public function methods_edit_get($id)
    {
        $method = SellerPaymentMethod::findOrFail($id);

        return view('backend.withdraws.method.edit', compact('method'));
    }

    public function methods_add_post(Request $request)
    {
        SellerPaymentMethod::create($request->input());

        return redirect()->route('backend.withdraws.method')->with('success', "Successfully added");
    }

    public function methods_edit_post($id, Request $request)
    {
        $method = SellerPaymentMethod::findOrFail($id);
        $method->update($request->input());
        $method->save();

        return redirect()->route('backend.withdraws.method')->with('success', "Successfully edited");
    }

    public function methods_delete($id)
    {
        $method = SellerPaymentMethod::findOrFail($id);
        $method->delete();

        return redirect()->back()->with("success", 'Successfully deleted!');
    }

    public function set_pending($id)
    {
        $method = SellerWalletWithdrawal::findOrFail($id);
        $method->update(['status' => 1]);
        $method->save();

        return redirect()->route('backend.withdraws.list')->with('success', "Successfully edited");
    }

    public function set_finished($id)
    {
        $method = SellerWalletWithdrawal::findOrFail($id);
        $method->update(['status' => 2]);
        $method->save();

        return redirect()->route('backend.withdraws.list')->with('success', "Successfully edited");
    }

    public function set_rejected($id)
    {
        $method = SellerWalletWithdrawal::findOrFail($id);
        $method->update(['status' => 3]);
        $method->save();

        return redirect()->route('backend.withdraws.list')->with('success', "Successfully edited");
    }
}