<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug',
            'description' => 'required|string',
            'number_of_tasks' => 'required|integer|min:0',
            'number_of_exams' => 'required|integer|min:0',
            'number_of_projects' => 'required|integer|min:0',
        ]);

        Course::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'number_of_tasks' => $request->number_of_tasks,
            'number_of_exams' => $request->number_of_exams,
            'number_of_projects' => $request->number_of_projects,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }


    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug,' . $course->id,
            'description' => 'nullable|string',
            'number_of_tasks' => 'required|integer|min:0',
            'number_of_exams' => 'required|integer|min:0',
            'number_of_projects' => 'required|integer|min:0',
        ]);

        $course->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'number_of_tasks' => $request->num_tasks,
            'number_of_exams' => $request->num_quizzes,
            'number_of_projects' => $request->num_projects,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }


    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
