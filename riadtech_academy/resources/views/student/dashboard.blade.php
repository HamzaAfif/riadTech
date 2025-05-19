<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
   <h2>Welcome, {{ $student->name }}</h2>

    <form method="POST" action="{{ route('student.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <h3>Your Info</h3>
    <p><strong>Email:</strong> {{ $student->email ?? 'N/A' }}</p>
    <p><strong>Birthday:</strong> {{ $student->birthdate ? \Carbon\Carbon::parse($student->birthday)->format('d/m/Y') : 'N/A' }}</p>

    <h3>Enrolled Courses</h3>
    @if($assignedCourses->count())
        <ul>
            @foreach($assignedCourses as $assignment)
                <li>
                    {{ $assignment->course->title }} — 
                    <strong>Status:</strong> {{ ucfirst($assignment->status) }} | 
                    <strong>Progress Step:</strong> {{ $assignment->progress }}
                </li>
            @endforeach
        </ul>
    @else
        <p>You have not been assigned any courses yet.</p>
    @endif
</body>
</html>
