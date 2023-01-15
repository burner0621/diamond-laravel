<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Auth;
use App\Http\Requests\PageStoreRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.page.index')->with(['pages' => Page::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::all(['name', 'id']);
        return view('backend.page.create')->with('parents', $pages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageStoreRequest $request)
    {
        $parent = Page::find($request->parent_id);

        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->name);

        if (Page::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $url = $slug;
        if ($parent) {
            $url = $parent->url . '/' . $slug;
        }

        $page = new Page;

        $page->status = $request->status;
        $page->name = $request->name;
        $page->post = $request->post;
        $page->slug = $slug;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->url = $url;
        $page->parent_id = $request->parent_id;
        $page->author_id = Auth::user()->id;
        $page->save();        

        return redirect()->route('backend.page.edit', $page->id);
    }
    
    public  function slugify($text, string $divider = '-')
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pages = Page::all(['name', 'id']);

        return view('backend.page.edit')->with(['page' => Page::find($id), 'parents' => $pages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parent = Page::find($request->parent_id);

        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->name);

        if (Page::where('slug', $slug)->where('id', '!=', $id)->count()) {
            $slug .= "-1";
        }

        $url = $slug;
        if ($parent) {
            $url = $parent->url . '/' . $slug;
        }

        $page = Page::find($id);

        $page->status = $request->status;
        $page->name = $request->name;
        $page->post = $request->post;
        $page->url = $url;
        $page->slug = $slug;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->parent_id = $request->parent_id;
        $page->author_id = Auth::user()->id;
        $page->save();

        return redirect()->route('backend.page.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::destroy($id);

        return redirect()->route('backend.page.index');
    }
}
