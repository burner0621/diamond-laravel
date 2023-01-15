<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCategoryStoreRequest;
use App\Models\CourseCategory;

class CourseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrCourseCategories = CourseCategory::all();

        return view('backend.course.categories.list', compact(
            'arrCourseCategories'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrCourseCategories = CourseCategory::all();

        return view('backend.course.categories.create', compact(
            'arrCourseCategories'
        ));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseCategoryStoreRequest $request)
    {
        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->category_name);

        if (CourseCategory::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $category = new CourseCategory;

        $category->category_excerpt = $request->category_excerpt;
        $category->parent_id = $request->parent_id;
        $category->category_name = $request->category_name;
        $category->slug = $slug;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();

        return redirect()->route('backend.courses.categories.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseCategory $category)
    {
        $arrCourseCategories = CourseCategory::where('id' ,'!=', $category->id)
            ->get();

        return view('backend.course.categories.edit', compact(
            'category', 'arrCourseCategories'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseCategoryStoreRequest $request, CourseCategory $category)
    {
        $slug = $this->slugify($request->slug);
        if ($request->slug == '')
            $slug = $this->slugify($request->category_name);

        if (CourseCategory::where('slug', $slug)->count()) {
            $slug .= "-1";
        }

        $category->category_excerpt = $request->category_excerpt;
        $category->parent_id = $request->parent_id;
        $category->category_name = $request->category_name;
        $category->slug = $slug;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();

        return redirect()->route('backend.courses.categories.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCategory $category)
    {
        $category->delete();

        return redirect()->route('backend.courses.categories.list');
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
