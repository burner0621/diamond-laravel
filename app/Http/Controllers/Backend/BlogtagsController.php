<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogTags;
use App\Http\Requests\TagStoreRequest;

class BlogtagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.blog.tags.list', [
            'tags' => BlogTags::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        $slug = $this->slugify($request->slug);

        if ($request->slug == '' || !$request->slug)
            $slug = $this->slugify($request->name);

        if (BlogTags::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $tag = new BlogTags;

        $tag->description = $request->description;
        $tag->name = $request->name;
        $tag->slug = $slug;
        $tag->meta_title = $request->meta_title;
        $tag->meta_description = $request->meta_description;
        $tag->save();        

        return redirect()->route('backend.blog.tags.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.blog.tags.edit', [
            'tag' => BlogTags::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagStoreRequest $request, $id)
    {
        $tag = BlogTags::findOrFail($id);
        $slug = $this->slugify($request->slug);

        if ($request->slug == '' || !$request->slug)
            $slug = $this->slugify($request->name);

        if (BlogTags::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $tag->description = $request->description;
        $tag->name = $request->name;
        $tag->slug = $slug;
        $tag->meta_title = $request->meta_title;
        $tag->meta_description = $request->meta_description;
        $tag->save();

        return redirect()->route('backend.blog.tags.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = BlogTags::findOrFail($id);
        $product->delete();
        return redirect()->route('backend.blog.tags.list');
    }
}
