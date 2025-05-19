
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
    <h1>All Registered Parents</h1>

    <table border="1" cellpadding="10" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parents as $parent)
                <tr>
                    <td>{{ $parent->id }}</td>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
