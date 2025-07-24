<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Protected Routes
Route::middleware(['auth:sanctum'])->group(
    function () {
        // create new course
        Route::post("/createNewCourse", [CourseController::class, 'store']);

        // Enrollment toggle
        Route::post('/enrollmentToggle', [CourseController::class, 'enrollmentToggle']);

        // get creator with courses
        Route::get('/getCreatorWithCourse/{id}', [CourseController::class, 'getCreatorWithCourse']);

        // get all categories
        Route::get('/categories', [CategoryController::class, 'index']);

        // get one course with details
        Route::get('/getOneCourse/{id}', [CourseController::class, 'show']);

        // toggle follow / Unfollow
        Route::post('/toggleFollow', [UserController::class, 'toggleFollow']);

        // Update course
        Route::put("/editCourse/{id}", [CourseController::class, 'editCourse']);

        // Delete course
        Route::delete("/deleteCourse/{id}", [CourseController::class, 'deleteCourse']);

        // get all course using filters and pagination
        Route::post("/getCourseUsingFilters", [CourseController::class, 'getCourseUsingFilters']);

        // delete user
        Route::delete("/deleteUserAccount", [UserController::class, 'deleteUserAccount']);
    }
);
