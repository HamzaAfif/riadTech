<!DOCTYPE html>
<html>
<head>
    <title>Parent Login</title>
</head>
<body>
    <h2>Parent Login</h2>

    <form method="POST" action="{{ route('student_parent.login.submit') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="{{ route('student_parent.register') }}">Register here</a></p>

    </form>
</body>
</html>
