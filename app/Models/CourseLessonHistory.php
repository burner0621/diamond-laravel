<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLessonHistory extends Model
{
    use HasFactory;

    protected $table = 'course_lesson_history';

    protected $fillable = [
        'user_id',
        'lesson_content_id',
        'status',
    ];
    
    public function content()
    {
        return $this->belongsTo(CourseLessonContent::class, 'lesson_content_id');
    }
}
