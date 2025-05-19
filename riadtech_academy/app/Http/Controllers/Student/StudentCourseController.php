<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\StudentCourseTask;
use App\Models\StudentCourseAssignment;


class StudentCourseController extends Controller
{
    // Ordered sequence of steps:
    protected $steps = [
        'task1','task2','task3','task4','task5',
        'quiz','project'
    ];

    /** Show the course overview / “start here” page */
    public function overview($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        // Blade view for overview should be resources/views/courses/{slug}/index.blade.php
        $viewName = "courses.{$slug}.index";

        abort_unless(view()->exists($viewName), 404, "Overview page not found.");

        return view($viewName, compact('course'));
    }

    /** Show a single step Blade view (task1 / quiz / project) */
    public function showStep($slug, $step)
    {
        $studentId = Auth::guard('student')->id();
        $course = Course::where('slug', $slug)->firstOrFail();

        // Mark task as in_progress (or get existing)
        StudentCourseTask::firstOrCreate(
            ['student_id' => $studentId, 'course_id' => $course->id, 'task_key' => $step],
            ['status' => 'in_progress', 'xp_earned' => 0]
        );

        // Compose Blade view path like: courses.PyKids.task1
        $viewName = "courses.{$slug}.{$step}";

        abort_unless(view()->exists($viewName), 404, "Step view not found.");

        $task = $step;  // or whatever you want to call it
        return view($viewName, compact('course', 'step', 'slug', 'task'));


    }

    /** Complete a step and redirect to the next one */
    public function completeStep(Request $request, $slug, $step)
        {
            $studentId = Auth::guard('student')->id();
            $course = Course::where('slug', $slug)->firstOrFail();

            $record = StudentCourseTask::where([
                ['student_id', $studentId],
                ['course_id', $course->id],
                ['task_key', $step]
            ])->firstOrFail();

            $record->update([
                'status'       => 'completed',
                'completed_at' => now(),
                'xp_earned'    => $request->input('xp_earned', $record->xp_earned),
            ]);

            // find next step
            $index = array_search($step, $this->steps);
            $next  = $this->steps[$index + 1] ?? null;

            if ($next) {
                return redirect()->route(
                    'student.courses.tasks.show',
                    ['slug' => $slug, 'step' => $next]
                );
            }

            // If no more steps, mark course assignment as completed
            StudentCourseAssignment::where('student_id', $studentId)
                ->where('course_id', $course->id)
                ->update([
                    'status' => 'completed',
                    'progress' => 100,
                    'updated_at' => now(),
                ]);

            return redirect()->route('student.dashboard')->with('success', 'Course completed!');
        }

        public function resumeOrStart($slug)
        {
            $studentId = Auth::guard('student')->id();
            $course = Course::where('slug', $slug)->firstOrFail();

            // Get all task records for this student + course
            $taskRecords = StudentCourseTask::where('student_id', $studentId)
                ->where('course_id', $course->id)
                ->get()
                ->keyBy('task_key'); // quick lookup by task key

            // Loop through the steps and find the first one not completed
            foreach ($this->steps as $step) {
                if (!isset($taskRecords[$step]) || $taskRecords[$step]->status !== 'completed') {
                    // Redirect to the next step to work on
                    return redirect()->route('student.courses.tasks.show', [
                        'slug' => $slug,
                        'step' => $step,
                    ]);
                }
            }

            // All tasks completed, redirect to dashboard
            return redirect()->route('student.dashboard')->with('info', 'You’ve completed this course!');
        }

}
