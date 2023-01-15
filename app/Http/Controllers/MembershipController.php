<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request) {
        $arrMemberships = Membership::all();

        return view('memberships.index', compact(
            'arrMemberships'
        ));
    }
}
