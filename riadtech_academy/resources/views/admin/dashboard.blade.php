@extends('layouts.admin')

@section('content')
<h2>Welcome, Admin!</h2>

<form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

{{-- Teachers Section --}}
<h2>Create a Teacher</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('admin.teachers.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Teacher Name" required>
    <input type="email" name="email" placeholder="Teacher Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Create Teacher</button>
</form>

<ul>
    <li><a href="{{ route('admin.teachers.index') }}">📚 View All Teachers</a></li>
    <li><a href="{{ route('admin.teachers.create') }}">➕ Add New Teacher</a></li>
</ul>

<a href="{{ route('admin.parents') }}">Manage Parents</a>

{{-- Courses Section --}}
<hr>

<h2>Courses Management</h2>

<ul>
    <li><a href="{{ route('admin.courses.index') }}">📚 View All Courses</a></li>
    <li><a href="{{ route('admin.courses.create') }}">➕ Create New Course</a></li>
</ul>

@endsection
