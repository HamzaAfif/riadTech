<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseTasksTable extends Migration
{
    public function up()
    {
        Schema::create('student_course_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // Use a string key to cover tasks/quizzes/projects
            $table->string('task_key');

            $table->enum('status', ['not_started', 'in_progress', 'completed'])
                  ->default('not_started');
            $table->integer('xp_earned')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['student_id', 'course_id', 'task_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_course_tasks');
    }
}
