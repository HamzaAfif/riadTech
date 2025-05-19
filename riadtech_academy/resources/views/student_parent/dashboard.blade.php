<!DOCTYPE html>
<html>
<head>
    <title>Parent Dashboard</title>
</head>
<body>
    <h1>Welcome, Parent!</h1>

    <form method="POST" action="{{ route('student_parent.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if(session('new_student_password'))
    <div class="alert alert-success">
        New student account created:<br>
        <strong>Name:</strong> {{ session('new_student_password.name') }}<br>
        <strong>Login:</strong> {{ session('new_student_password.login') }}<br>
        <strong>Password:</strong> {{ session('new_student_password.password') }}
    </div>
@endif



    <h2>Add a Child</h2>
    <form action="{{ route('student_parent.students.store') }}" method="POST">
        @csrf
        <label>Name (required):</label>
        <input type="text" name="name" required>

        <label>Birthdate (required):</label>
        <input type="date" name="birthdate" required>

        <label>Email (optional):</label>
        <input type="email" name="email">

        <button type="submit">Create Student</button>
    </form>
<h2>My Children</h2>

@if($children->isEmpty())
    <p>No children registered yet.</p>
@else
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Birthdate</th>
                <th>Login</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach($children as $child)
                <tr>
                    <td>{{ $child->name }}</td>
                    <td>{{ $child->birthdate ? $child->birthdate->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $child->login }}</td>
                    <td>
                        <form method="POST" action="{{ route('student_parent.students.generate_password', $child->id) }}">
                            @csrf
                            <button type="submit">Generate New Password</button>
                        </form>

                        <!-- Show generated password once -->
                        @if(session('generated_password.student_id') == $child->id)
                            <div>
                                <strong>New password:</strong> {{ session('generated_password.password') }}
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@foreach ($children as $student)
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
        <h3>{{ $student->name }}</h3>

        <h4>Assigned Courses:</h4>
        @if ($student->courseAssignments->isEmpty())
            <p>No courses assigned yet.</p>
        @else
            <ul>
                @foreach ($student->courseAssignments as $assignment)
                    <li>
                        {{ $assignment->course->title }} - 
                        <strong>{{ ucfirst(str_replace('_', ' ', $assignment->status)) }}</strong> 
                        (Progress: Step {{ $assignment->progress }})
                    </li>
                @endforeach
            </ul>
        @endif

        <h4>Assign New Course:</h4>
        <form method="POST" action="{{ route('student_parent.assign_course') }}">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">

            <select name="course_id" required>
                @foreach ($courses as $course)
                    @php
                        $alreadyAssigned = $student->courseAssignments->contains('course_id', $course->id);
                    @endphp
                    <option value="{{ $course->id }}" {{ $alreadyAssigned ? 'disabled' : '' }}>
                        {{ $course->title }} {{ $alreadyAssigned ? '(Already assigned)' : '' }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Assign Course</button>
        </form>
    </div>
@endforeach


<script>
function togglePassword(id) {
    const input = document.getElementById('pass-' + id);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>

</body>
</html>
