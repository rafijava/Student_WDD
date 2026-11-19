<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Enrollment::with(['student', 'course'])->paginate(15)
        );
    }

    public function store(StoreEnrollmentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $studentId = $validated['student_id'];
        $courseId  = $validated['course_id'];

        $existing = Enrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Duplicate enrollment: this student is already enrolled in the selected course.',
                'enrollment' => $existing,
            ], 422);
        }

        $course = Course::findOrFail($courseId);

        $activeCount = Enrollment::where('course_id', $courseId)
            ->active()
            ->count();

        if ($activeCount >= $course->capacity) {
            return response()->json([
                'message' => 'Course capacity is full.',
                'capacity'   => $course->capacity,
                'enrolled'   => $activeCount,
            ], 422);
        }

        try {
            $enrollment = Enrollment::create($validated);
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), '1062 Duplicate entry') ||
                str_contains($e->getMessage(), 'unique')) {
                return response()->json([
                    'message' => 'Duplicate enrollment: this student is already enrolled in the selected course.',
                ], 422);
            }

            throw $e;
        }

        return response()->json([
            'message'    => 'Enrollment created successfully.',
            'enrollment' => $enrollment->load(['student', 'course']),
        ], 201);
    }
}
