<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\AvailableCourseResource;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAvailableCourses(Request $request)
    {
        try {
            $user = $request->user();

           
            $currentCourseId = $user->userDetails->course_id ?? null;

        
            $courses = Course::when($currentCourseId, function ($query) use ($currentCourseId) {
                $query->where('id', '!=', $currentCourseId);
            })->get();

            return ApiResponse::success(
                AvailableCourseResource::collection($courses),
                'Available courses retrieved successfully'
            );
        } catch (\Exception $e) {
            \Log::error('Get Available Courses Error: ' . $e->getMessage());
            return ApiResponse::error('Failed to retrieve available courses.', 500);
        }
    }
}
