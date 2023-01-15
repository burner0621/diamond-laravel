<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogPostCategorie;
use App\Models\BlogCategorie;
use App\Http\Requests\CategorieStoreRequest;


class BlogcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.blog.categories.list', [
            'categories' => BlogCategorie::all()
        ]);  
    }


    public function get()
    {
        return datatables()->of(BlogCategorie::query())
        ->addIndexColumn()
        ->addColumn('action', function($row){

               $btn = '<a href="'.route('products.show', $row->id).'" target="_blank" class="edit btn btn-info btn-sm">View</a>';
               $btn = $btn.'<a href="'.route('backend.categories.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
               $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blog.categories.create', [
            'categories' => BlogCategorie::all()
        ]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieStoreRequest $request)
    {
        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->category_name);

        if (BlogCategorie::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $category = new BlogCategorie;

        $category->category_excerpt = $request->category_excerpt;
        $category->parent_id = $request->parent_id;
        $category->category_name = $request->category_name;
        $category->slug = $slug;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();

        return redirect()->route('backend.blog.categories.list');
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
        return view('backend.blog.categories.edit',[
            "category" => BlogCategorie::findOrFail($id),
            'categories' => BlogCategorie::where('id' ,'!=' , $id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategorieStoreRequest $request, $id)
    {
        $category = BlogCategorie::findOrFail($id);

        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->category_name);

        if (BlogCategorie::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $category->category_excerpt = $request->category_excerpt;
        $category->parent_id = $request->parent_id;
        $category->category_name = $request->category_name;
        $category->slug = $slug;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();

        return redirect()->route('backend.blog.categories.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $firstId = BlogCategorie::first()->id;

        if ($firstId != $id) {
            $product = BlogCategorie::findOrFail($id);
            $product->delete();
            
            BlogPostCategorie::where('id_category', $id)->update(['id_category' => $firstId]);
        }

        return redirect()->route('backend.blog.categories.list');
    }
}
