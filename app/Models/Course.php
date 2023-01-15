<?php

namespace App\Models;

use App\Models\Traits\FormatPrices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, FormatPrices;

    protected $fillable = [
        'user_id', 'name', 'slug', 'price', 'description', 'video_url', 'category_id', 'thumbnail',
    ];

    protected $appends = [
        'category_name', 'author_name',
    ];

    /**
     * Get the category name attributes
     */
    public function getCategoryNameAttribute()
    {
        return $this->category?->category_name;
    }

    /**
     * Get the category name attributes
     */
    public function getAuthorNameAttribute()
    {
        $author = $this->author;

        if ($author == null) {
            return '';
        }

        return $author->first_name . ' ' . $author->last_name;
    }

    /**
     * Get category with course
     */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    /**
     * Get category with course
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get lesson associate with course
     */
    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id');
    }

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'thumbnail', 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null,
        ]);
    }
}