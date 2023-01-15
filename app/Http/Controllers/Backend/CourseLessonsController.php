<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLessonContentStoreRequest;
use App\Http\Requests\CourseLessonStoreRequest;
use App\Models\CourseLesson;
use App\Models\CourseLessonContent;
use Illuminate\Http\Request;

class CourseLessonsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseLessonStoreRequest $request)
    {
        $lesson = new CourseLesson;

        $lesson->course_id = $request->course_id;
        $lesson->name = $request->name;
        $lesson->save();

        $lessons = CourseLesson::where('course_id', $lesson->course_id)
            ->orderBy('id')
            ->get();

        $lesson_html = view('backend.course.courses.edit.lesson_items', compact(
                'lessons'
            ))->render();

        return response()->json([
            'result'        => true,
            'lessons_html'  => $lesson_html,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseLessonStoreRequest $request)
    {
        $lesson = CourseLesson::findOrFail($request->lesson_id);
        $lesson->name = $request->name;
        $lesson->save();
        $lessons = CourseLesson::where('course_id', $lesson->course_id)
            ->orderBy('id')
            ->get();

        $lesson_html = view('backend.course.courses.edit.lesson_items', compact(
                'lessons'
            ))->render();

        return response()->json([
            'result'        => true,
            'lessons_html'  => $lesson_html,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $lesson = CourseLesson::findOrFail($request->lesson_id);
        $lesson->delete();
        CourseLessonContent::where('lesson_id', $lesson->id)
            ->delete();

        $lessons = CourseLesson::where('course_id', $lesson->course_id)
            ->orderBy('id')
            ->get();

        $lesson_html = view('backend.course.courses.edit.lesson_items', compact(
                'lessons'
            ))->render();

        return response()->json([
            'result'        => true,
            'lessons_html'  => $lesson_html,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_content(CourseLessonContentStoreRequest $request)
    {
        $content = new CourseLessonContent;

        $content->lesson_id = $request->lesson_id;
        $content->name = $request->name;
        $content->content = $request->content;
        $content->save();
        $course_id = $content->lesson->course_id;
        
        $lessons = CourseLesson::where('course_id', $course_id)
            ->orderBy('id')
            ->get();

        $lesson_html = view('backend.course.courses.edit.lesson_items', compact(
            'lessons'
        ))->render();

        return response()->json([
            'result'        => true,
            'lessons_html'  => $lesson_html,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_content(CourseLessonContentStoreRequest $request)
    {
        $content = CourseLessonContent::findOrFail($request->content_id);

        $content->name = $request->name;
        $content->content = $request->content;
        $content->save();
        $lesson = $content->lesson;
        $lessons = CourseLesson::where('course_id', $lesson->course_id)
            ->orderBy('id')
            ->get();

        $lesson_html = view('backend.course.courses.edit.lesson_items', compact(
                'lessons'
            ))->render();

        return response()->json([
            'result'        => true,
            'lessons_html'  => $lesson_html,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_content(Request $request)
    {
        $lesson_content = CourseLessonContent::findOrFail($request->lesson_content_id);
        $lesson_content->delete();
        $lesson = $lesson_content->lesson;

        $lessons = CourseLesson::where('course_id', $lesson->course_id)
            ->orderBy('id')
            ->get();

        $lesson_html = view('backend.course.courses.edit.lesson_items', compact(
                'lessons'
            ))->render();

        return response()->json([
            'result'        => true,
            'lessons_html'  => $lesson_html,
        ]);
    }
}
