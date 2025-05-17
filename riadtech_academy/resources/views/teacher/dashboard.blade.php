<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ Auth::guard('teacher')->user()->name }}</h1>

    <form method="POST" action="{{ route('teacher.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
