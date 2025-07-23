<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'language_id',
        'proficiency_id',
        'pricing_id',
        'based_price',
        'discounted_price',
        'discount_start_date',
        'discount_end_date',
        'requirements',
        'goals',
        'image_url'
    ];

    protected $casts = [
        'requirements' => 'array',
        'goals' => 'array',
        'based_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
    ];


    // return the user that has created this course
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // return the category of the course
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // return the language of course
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    // return the proficiency (the level of difficulty of the course)
    public function proficiency()
    {
        return $this->belongsTo(Proficiency::class, 'proficiency_id');
    }

    // return the pricing type
    public function pricing()
    {
        return $this->belongsTo(Pricing::class, 'pricing_id');
    }

    // return the enrolled users to this course
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withTimestamps();
    }
}
