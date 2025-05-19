<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <meta charset="UTF-8">
</head>
<body>

    <h2>Add New Student</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('student_parent.students.store') }}">
        @csrf

        <div>
            <label>Name:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div><br>

        <div>
            <label>Login:</label><br>
            <input type="text" name="login" value="{{ old('login') }}" required>
        </div><br>

        <div>
            <label>Email (optional):</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </div><br>

        <div>
            <label>Birthdate:</label><br>
            <input type="date" name="birthdate" value="{{ old('birthdate') }}">
        </div><br>

        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div><br>

        <button type="submit">Add Student</button>
    </form>

    <br>
    <a href="{{ route('student_parent.dashboard') }}">← Back to Dashboard</a>

</body>
</html>
