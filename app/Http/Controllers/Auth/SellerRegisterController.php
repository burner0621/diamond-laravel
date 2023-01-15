<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\SellersProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
class SellerRegisterController extends Controller
{
    /**
     * Display the seller registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.seller-register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if(Auth::user()){
            $request->validate([
                'business_name' => ['required', 'string'],
                'whatsapp' => ['required', 'string'],
                'slogan' => ['required', 'string'],
                'about' => ['required', 'string'],
            ]);
        }
        else {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'username' => ['required', 'unique:users,username'],
                'business_name' => ['required', 'string'],
                'whatsapp' => ['required', 'string'],
                'slogan' => ['required', 'string'],
                'about' => ['required', 'string'],
            ]);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => 2,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            Auth::login($user);
        }
        $user = Auth::user();
        if( SellersProfile::where("user_id", $user->id)->count() ){
            // User already have seller account
        }
        else {
            $seller = SellersProfile::create([
                'user_id'   => $user->id,
                'business_name' => $request->business_name,
                'whatsapp' => $request->whatsapp,
                'slogan' => $request->slogan,
                'about'     => $request->about,
            ]);
            event(new Registered($user));
        }
        return redirect()->route('seller.dashboard');
    }
}
