@extends('layouts.admin')

@section('content')
    <h2>All Teachers</h2>

    <a href="{{ route('admin.teachers.create') }}">Create Teacher</a>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr><th>Name</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>
                    <a href="{{ route('admin.teachers.show', $teacher) }}">View</a>
                    <a href="{{ route('admin.teachers.edit', $teacher) }}">Edit</a>
                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
