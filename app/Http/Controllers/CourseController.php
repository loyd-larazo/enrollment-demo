<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;

class CourseController extends Controller
{
  public function index(Request $request) {
    $courses = Course::get();

    return response()->json(['data' => $courses]);
  }

  public function store(Request $request) {
    $course = $request->get('course');
    $years = $request->get('years');
    $description = $request->get('description');

    if (!$course || !$years) {
      return response()->json(['error' => 'Please enter all required fields!'], 401);
    }

    $courseModel = Course::where('course', $course)->first();
    if ($courseModel) {
      return response()->json(['error' => 'Course is already exists!'], 401);
    }

    $newCourse = Course::create([
      'course' => $course,
      'years' => $years,
      'description' => $description
    ]);

    return response()->json(['data' => $newCourse]);
  }

  public function update(Request $request, $courseId) {
    $course = $request->get('course');
    $years = $request->get('years');
    $description = $request->get('description');

    $courseModel = Course::where('id', $courseId)->first();
    if (!$courseModel) {
      return response()->json(['error' => 'Course not found!'], 404);
    }

    if (!$course || !$years) {
      return response()->json(['error' => 'Please enter all required fields!'], 401);
    }

    $courseNameExists = Course::where('course', $course)->where('id', '!=', $courseId)->first();
    if ($courseNameExists) {
      return response()->json(['error' => 'Course is already exists!'], 401);
    }

    $courseModel->course = $course;
    $courseModel->years = $years;
    $courseModel->description = $description;
    $courseModel->save();

    return response()->json(['data' => $courseModel]);
  }

  public function delete(Request $request, $courseId) {
    $courseModel = Course::where('id', $courseId)->first();
    if (!$courseModel) {
      return response()->json(['error' => 'Course not found!'], 404);
    }

    $courseModel->delete();

    return response()->json(['data' => 'success']);
  }
}
