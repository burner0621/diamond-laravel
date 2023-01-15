<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(int $id_user, Request $request)
    {
        $tab = "account";
        if ($request->has("tab")) {
            $tab = $request->input("tab");
        }
        $user = User::findOrFail($id_user);
        $shipping_address = UserAddress::find(auth()->user()->address_shipping);
        $billing_address = UserAddress::find(auth()->user()->address_billing);
        $this->authorize('seeInfo', $user);

        if ($id_user == Auth::id()) {
            return redirect()->route('user.edit', ['tab' => $tab]);
        }
        return view('users.index', ['user' => $user, 'shipping' => $shipping_address, 'billing' => $billing_address, 'tab' => $tab]);
    }

    public function edit(Request $request)
    {
        $tab = "account";
        if ($request->has("tab")) {
            $tab = $request->input("tab");
        }
        $shipping_address = UserAddress::find(auth()->user()->address_shipping);
        $billing_address = UserAddress::find(auth()->user()->address_billing);
        $countries = Country::all(['name', 'code']);
        // dd($countries);
        return view('users.edit', ['shipping' => $shipping_address, 'billing' => $billing_address, 'countries' => $countries, 'tab' => $tab]);
    }

    public function editPassword()
    {
        return view('users.edit_password', ['tab' => 'security']);
    }

    public function update_account(UpdateUserRequest $req)
    {
        $username = $req->input('username');

        if ($username != '') {
            if (User::where('id', '<>', Auth::id())->where('username', $username)->exists()) {
                return redirect()->back()->withErrors(['Invalid Username' => 'Username already exist!']);
            }
        }

        $first_name = $req->input('first_name');
        $last_name = $req->input('last_name');
        $user = Auth::user();
        $user->update(['first_name' => $first_name, 'last_name' => $last_name, 'username' => $username]);

        if ($req->has('avatar')) {
            $user->update(['avatar' => $req->input('avatar')]);
        }

        return redirect()->route('user.edit', ['tab' => "account"])->with("success", "Account successfully updated.");
    }

    public function update_address(UpdateAddressRequest $req)
    {
        auth()->user()->update($req->all());
        // Save or Update Shipping Address
        if (auth()->user()->address_shipping) {
            $address1 = UserAddress::find(auth()->user()->address_shipping);
        } else {
            $address1 = new UserAddress;
        }
        $address1->user_id = Auth()->user()->id;
        $address1->address = $req->shipping_address1;
        $address1->address2 = $req->shipping_address2;
        $address1->city = $req->shipping_city;
        $address1->state = $req->shipping_state;
        $address1->country = $req->shipping_country;
        $address1->postal_code = $req->shipping_pin_code;
        if (auth()->user()->address_shipping) {
            $address1->update();
        } else {
            $address1->save();
        }

        auth()->user()->update(['address_shipping' => $address1->id]);

        if (!$req->billing_address1 && !$req->billing_address2 && !$req->billing_city && !$req->billing_country && !$req->billing_state && !$req->billing_pin_code) {
            if (auth()->user()->address_billing) {
                $address2 = UserAddress::find(auth()->user()->address_billing)->delete();
                auth()->user()->update(['address_billing' => null]);
            }
            return redirect()->route('user.edit', ['tab' => "address"])->with("success", "Address updated!");
        }

        if (!$req->billing_address1 || !$req->billing_city || !$req->billing_country || !$req->billing_state || !$req->billing_pin_code) {
            return redirect()->route('user.edit', ['tab' => "address"])->with("success", "Address updated!");
        }

        if (auth()->user()->address_billing) {
            $address2 = UserAddress::find(auth()->user()->address_billing);
        } else {
            $address2 = new UserAddress;
        }
        $address2->user_id = auth()->user()->id;
        $address2->address = $req->billing_address1;
        $address2->address2 = $req->billing_address2;
        $address2->city = $req->billing_city;
        $address2->state = $req->billing_state;
        $address2->country = $req->billing_country;
        $address2->postal_code = $req->billing_pin_code;
        if (auth()->user()->address_billing) {
            $address2->update();
        } else {
            $address2->save();
        }
        auth()->user()->update(['address_billing' => $address2->id]);

        return redirect()->route('user.edit', ['tab' => "address"])->with("success", "Address updated!");
    }

    public function updatePassword(UpdateUserPasswordRequest $req)
    {
        auth()->user()->update([
            'password' => bcrypt($req->new_password),
        ]);
        return redirect()->route('user.edit.password')->with('success', 'Password was Successfully Changed!');
    }

    public function delete()
    {
        auth()->user()->delete();
        return redirect()->route('index');
    }

    public function disable()
    {
        auth()->user()->update(['role' => 4]);
        return redirect()->route('logout');
    }
}
