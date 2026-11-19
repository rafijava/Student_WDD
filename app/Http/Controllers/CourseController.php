<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Course::with('enrollments')->paginate(15)
        );
    }

    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = Course::create($request->validated());

        return response()->json([
            'message' => 'Course created successfully.',
            'course'  => $course,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $course = Course::with('enrollments')->findOrFail($id);

        return response()->json([
            'course' => $course,
        ]);
    }

    public function update(UpdateCourseRequest $request, string $id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $course->update($request->validated());

        return response()->json([
            'message' => 'Course updated successfully.',
            'course'  => $course->fresh(),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully.',
        ]);
    }
}
