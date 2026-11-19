<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Student::with('enrollments')->paginate(15)
        );
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $student = Student::create($request->validated());

        return response()->json([
            'message' => 'Student created successfully.',
            'student' => $student,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $student = Student::with('enrollments')->findOrFail($id);

        return response()->json([
            'student' => $student,
        ]);
    }

    public function update(UpdateStudentRequest $request, string $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $student->update($request->validated());

        return response()->json([
            'message' => 'Student updated successfully.',
            'student' => $student->fresh(),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.',
        ]);
    }
}
