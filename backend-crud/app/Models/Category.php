<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $fillable = [
        'name'
    ];


    // return all course that belongs to a category (category has many course)
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
