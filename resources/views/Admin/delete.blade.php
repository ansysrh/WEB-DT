<!DOCTYPE html>
<html>
<head>
    <title>Edit Admin</title>
</head>
<body>
    <h1>Edit Admin</h1>

    <form action="{{ route('admin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Name:</label>
        <input type="text" name="name" value="{{ $admin->name }}"><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $admin->email }}"><br><br>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('admin.index') }}">Back</a>
</body>
</html>
