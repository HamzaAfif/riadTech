<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
</head>
<body>
    <h2>Login as Teacher</h2>
    <form method="POST" action="{{ route('teacher.login.submit') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif
</body>
</html>
