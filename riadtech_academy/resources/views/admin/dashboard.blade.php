

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

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

</body>
</html>
