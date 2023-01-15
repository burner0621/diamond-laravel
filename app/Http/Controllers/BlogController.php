<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogTags;
use App\Models\BlogCategorie;
use App\Models\BlogPostTag;
use App\Models\BlogPostCategorie;

class BlogController extends Controller
{

    public function index()
    {
        return view('blog.list', [
            'posts' => BlogPost::with(['categories', 'uploads', 'postauthor'])->orderBy('id', 'DESC')->get()
        ]);
    }
    
    public function show($slug)
    {
        return view('blog.show', [
            'post' => BlogPost::where('slug', $slug)->firstOrFail(),
            'categories' => BlogCategorie::all(),
            'tags' => BlogTags::all()
        ]);
    }
    public function categoryAll()
    {
        return view('blog.category.all', [
            'categories' => BlogCategorie::all()
        ]);  

    }
    public function categoryPost($category)
    {
        return view('blog.category.all', [
            'categories' => BlogCategorie::all()
        ]);
        return view('blog.category.show', [
            'post' => BlogPost::where('slug', $slug)->firstOrFail(),
            'categories' => BlogCategorie::all(),
            'tags' => BlogTags::all()
        ]);  

    }
    public function tagAll()
    {
        return view('blog.tag.all', [
            'tags' => BlogTags::all()
        ]);  

    }
    public function tagPost($tag)
    {
        return view('blog.category.all', [
            'categories' => BlogCategorie::all()
        ]);  

    }

}
