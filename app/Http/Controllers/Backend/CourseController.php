<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseStoreRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function slugify($text, string $divider = '-')
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with(['category', 'author'])
            ->orderBy('id', 'DESC')->get();

        $courses->each(function ($course) {
            $course->setPriceToFloat();
        });

        return view('backend.course.courses.list', compact(
            'courses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrCategories = CourseCategory::get();

        return view('backend.course.courses.create', compact(
            'arrCategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        $data = $request->input();
        $data['user_id'] = Auth::id();
        $data['price'] = Course::stringPriceToCents($request->price);

        $slug = $this->slugify($request->slug);
        if ($request->slug == '') {
            $slug = $this->slugify($request->name);
        }

        if (Course::where('slug', $slug)->count()) {
            $slug .= "-1";
        }
        $data['slug'] = $slug;

        $course_id = Course::create($data)->id;

        return redirect()->route('backend.courses.edit', $course_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $course->setPriceToFloat();
        $arrCategories = CourseCategory::get();

        return view('backend.course.courses.edit', compact(
            'course', 'arrCategories'
        ));
    }

    public function update(Course $course, Request $request)
    {
        $data = $request->input();
        $data['price'] = $data['price'] * 100;
        $course->update($data);

        return redirect()->back()->with("success", "Successfully changed!");
    }
}