<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('login')->unique(); // Used to login
        $table->string('email')->nullable();
        $table->string('password'); // Hashed password
        $table->date('birthdate')->nullable();

        $table->foreignId('teacher_id')->nullable()->constrained()->onDelete('set null');

        $table->unsignedBigInteger('parent_id')->nullable();
        $table->foreign('parent_id')->references('id')->on('student_parents')->onDelete('set null');

        $table->unsignedBigInteger('class_id')->nullable(); // Later we'll connect to classes

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
