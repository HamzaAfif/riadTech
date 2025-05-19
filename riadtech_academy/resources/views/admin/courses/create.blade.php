@extends('layouts.admin')

@section('content')
<h2>Create New Course</h2>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.courses.store') }}">
    @csrf
    <input type="text" name="title" placeholder="Course Title" required><br>
    <input type="text" name="slug" placeholder="Course Slug" required><br>
    <textarea name="description" placeholder="Course Description" required></textarea><br>
    <input type="number" name="number_of_tasks" placeholder="Number of Tasks" required><br>
    <input type="number" name="number_of_exams" placeholder="Number of Quizzes" required><br>
    <input type="number" name="number_of_projects" placeholder="Number of Projects" required><br>
    <button type="submit">Create Course</button>
</form>
@endsection
