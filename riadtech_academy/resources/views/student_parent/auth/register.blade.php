<!DOCTYPE html>
<html>
<head>
    <title>Parent Registration</title>
</head>
<body>
    <h2>Register as a Parent</h2>

    <form method="POST" action="{{ route('student_parent.register.submit') }}">
        @csrf

        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
        @error('name')<div style="color:red">{{ $message }}</div>@enderror
        <br>

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        @error('email')<div style="color:red">{{ $message }}</div>@enderror
        <br>

        <input type="password" name="password" placeholder="Password" required>
        @error('password')<div style="color:red">{{ $message }}</div>@enderror
        <br>

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('student_parent.login') }}">Login here</a></p>
</body>
</html>
