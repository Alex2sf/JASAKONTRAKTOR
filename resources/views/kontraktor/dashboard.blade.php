<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kontraktor</title>
</head>
<body>
    <h1>Welcome, Kontraktor!</h1>

    <!-- Tombol menuju halaman profil kontraktor -->
    <a href="{{ route('kontraktor.profile') }}">
        <button type="button">Lihat Profil</button>
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
