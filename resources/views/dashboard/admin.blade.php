<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>

<body>

    <h1>Dashboard Admin</h1>

    <p>Halo, {{ session('username') }}</p>
    <p>Role: {{ session('role') }}</p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>

</html>