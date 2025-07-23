<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequests\CourseUsingFiltersRequest;
use App\Http\Requests\CourseRequests\EnrollmentRequest;
use App\Http\Requests\CourseRequests\StoreCourseRequest;
use App\Http\Requests\CourseRequests\UpdateCourseRequest;
use App\Http\Requests\RequestUpdateCourse;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with([
            'creator:id,name,email',
            'category:id,name',
            'proficiency:id,level',
            'language:id,name',
            'pricing:id,type',
        ])
            ->withCount('enrolledUsers')
            ->latest()
            ->paginate(10)
            ->onEachSide(1);


        return response()->json([
            "message" => "all courses",
            'courses' => $courses
        ], 200);
    }



    /**
     * get list of courses using filters
     */

    public function getCourseUsingFilters(CourseUsingFiltersRequest $request)
    {
        $validated = $request->validated();

        $courses = Course::with([
            'creator:id,name,email',
            'category:id,name',
            'proficiency:id,level',
            'language:id,name',
            'pricing:id,type',
        ])
            ->withCount('enrolledUsers');

        // Filter by title
        if (filled($validated["searchTitle"])) {
            $courses = $courses->where('title', 'like', "%" . $validated["searchTitle"] . "%");
        }

        // Filter by creator name
        if (filled($validated["searchAuthor"])) {
            $courses = $courses->whereHas('creator', function ($query) use ($validated) {
                $query->where('name', 'like', "%" . $validated["searchAuthor"] . "%");
            });
        }

        // Filter by category
        if (!empty($validated["categoriesId"])) {
            $courses = $courses->whereIn('category_id', $validated["categoriesId"]);
        }

        // Filter by proficiency
        if (!empty($validated["proficienciesId"])) {
            $courses = $courses->whereIn('proficiency_id', $validated["proficienciesId"]);
        }

        // Filter by language
        if (!empty($validated["languagesId"])) {
            $courses = $courses->whereIn('language_id', $validated["languagesId"]);
        }

        // Filter by pricing
        if (!empty($validated["pricingId"])) {
            $courses = $courses->whereIn('pricing_id', $validated["pricingId"]);
        }

        // Final query with pagination
        $courses = $courses->latest()
            ->paginate(10)
            ->onEachSide(1);

        return response()->json([
            "message" => "all courses",
            'courses' => $courses
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            // validate data
            $validated = $request->validated();

            // Store the image and get the path
            $path = $request->file('image')->store('uploads', 'public');

            // Insert image path into validated data
            $validated['image_url'] = $path;

            // Remove the 'image' field (not in DB)
            unset($validated['image']);

            // create the course
            $course = Course::create($validated);

            return response()->json([
                'message' => 'Course created successfully',
                'course' => $course
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        // get the course with the id
        $course = Course::with([
            'creator:id,name,email',
            'category:id,name',
            'proficiency:id,level',
            'language:id,name',
            'pricing:id,type'
        ])
            ->withCount('enrolledUsers')
            ->findOrFail($id);


        // verify the status of enrollment of the authenticated user
        $user_id = Auth::user()->id;

        // verify the enrollment of the authenticated user to this course
        $bool_enroll = Enrollment::where('user_id', $user_id)
            ->where('course_id', $id)
            ->exists();

        return response()->json([
            "message" => "success",
            'course' => $course,
            'enroll' => $bool_enroll
        ], 200);
    }

    /**
     * get creator with his courses that he/she has created
     */
    public function getCreatorWithCourse($creator_id)
    {
        $validator = Validator::make(
            ['creator_id' => $creator_id],
            ['creator_id' => 'required|integer|exists:users,id']
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $creator = User::withCount('followers')
            ->withCount('followings')
            ->findOrFail($creator_id);

        $courses = $creator->courses()->with([
            'creator:id,name,email',
            'category:id,name',
            'proficiency:id,level',
            'language:id,name',
            'pricing:id,type'
        ])
            ->withCount('enrolledUsers')
            ->get();
        $follow_bool = Follow::where('followed_id', $creator_id)
            ->where('follower_id', Auth::user()->id)
            ->exists();
        return response()->json([
            'message' => 'success',
            'creator' => $creator,
            "courses" => $courses,
            'followed' => $follow_bool
        ], 200);
    }

    // toggle enrollment of a user in a course
    public function enrollmentToggle(EnrollmentRequest $request)
    {
        try {
            $validated = $request->validated();
            // get the value of user_id and course_id
            $user_id = $validated["user_id"];
            $course_id = $validated["course_id"];

            // searching about the enrollment
            $enrollment = Enrollment::where('user_id', $user_id)
                ->where('course_id', $course_id)
                ->first();


            if ($enrollment) {
                // User is already enrolled —> Unenroll
                $enrollment->delete();
                //count learner
                $count_learner = Course::findOrFail($course_id)->enrolledUsers()->count();
                return response()->json([
                    'enrolled' => false,
                    'count_learner' => $count_learner,
                    'message' => 'user has unenrolled'
                ], 200);
            } else {
                // Not enrolled --> Enroll
                Enrollment::create([
                    'user_id' => $user_id,
                    'course_id' => $course_id
                ]);
                //count learner
                $count_learner = Course::findOrFail($course_id)->enrolledUsers()->count();

                return response()->json([
                    'message' => 'User enrolled in course',
                    'count_learner' => $count_learner,
                    'enrolled' => true,
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $th->getMessage()
            ], 500);
        }
    }



    public function editCourse(UpdateCourseRequest $request, $id)
    {
        // Validate the data
        $validated = $request->validated();

        // Find the course
        $course = Course::findOrFail($id);

        // If a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($course->image_url && Storage::disk('public')->exists($course->image_url)) {
                Storage::disk('public')->delete($course->image_url);
            }

            // Store the new image and get the path
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image_url'] = $path;
            unset($validated['image']);
        }

        // Update the course with the new validated data
        $course->update($validated);

        return response()->json([
            "message" => "Course updated successfully",
            "course" => $course,
        ]);
    }


    /**
     * Delete course by id
     */

    public function deleteCourse($id)
    {
        // find course by id
        $course = Course::findOrFail($id);

        // Delete the old image if it exists
        if ($course->image_url && Storage::disk('public')->exists($course->image_url)) {
            Storage::disk('public')->delete($course->image_url);
        }

        // Delete Course from the database
        $course->delete();

        return response()->json([
            "message" => "Course Successfully Delete",
        ]);
    }
}
