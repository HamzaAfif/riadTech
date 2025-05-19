<!DOCTYPE html>
<html>
<head>
    <title>Courses List</title>
</head>
<body>
    <h1>All Courses</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.courses.create') }}">Create New Course</a>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Tasks</th>
                <th>Exams</th>
                <th>Projects</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->number_of_tasks }}</td>
                    <td>{{ $course->number_of_exams }}</td>
                    <td>{{ $course->number_of_projects }}</td>
                    <td>
                        <a href="{{ route('admin.courses.edit', $course) }}">Edit</a> |
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No courses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
