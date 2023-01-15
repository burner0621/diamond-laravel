<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipStoreRequest;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

class MembershipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberships = Membership::orderBy('id', 'DESC')->get();

        return view('backend.memberships.list', compact(
            'memberships'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MembershipStoreRequest $request)
    {
        $data = $request->input();
        $data['user_id'] = Auth::id();
        $data['price'] = Membership::stringPriceToCents($request->price);
        $data['price_monthly'] = Membership::stringPriceToCents($request->price_monthly);
        
        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->name);

        if (Membership::where('slug', $slug)->count()) {
            $slug .= "-1";
        }
        $data['slug'] = $slug;

        Membership::create($data)->id;
        
        return redirect()->route('backend.memberships.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Membership $membership)
    {
        $membership->setPricesToFloat();

        return view('backend.memberships.edit', compact(
            'membership'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Membership $membership, MembershipStoreRequest $request)
    {
        $data = $request->input();
        $data['user_id'] = Auth::id();
        $data['price'] = Membership::stringPriceToCents($request->price);
        $data['price_monthly'] = Membership::stringPriceToCents($request->price_monthly);

        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->name);

        $slug_count = Membership::where('slug', $slug)
            ->whereNot('id', $membership->id)
            ->count();

        if ($slug_count) {
            $slug .= "-1";
        }
        $data['slug'] = $slug;

        $membership->update($data);

        return redirect()->route('backend.memberships.list');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        $membership->delete();
        return redirect()->route('backend.memberships.list');
    }

    protected function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
