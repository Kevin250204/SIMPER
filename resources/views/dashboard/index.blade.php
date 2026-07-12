<h1>Dashboard</h1>
<p>Halo {{ session('username') }} ({{ session('role') }})</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>