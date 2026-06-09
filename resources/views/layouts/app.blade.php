<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Maya Bay')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    @yield('styles')
</head>
<body>

    <nav>
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('sobre-nosotros') }}">Sobre Nosotros</a>
        <a href="{{ route('habitaciones') }}">Habitaciones</a>
        <a href="{{ route('transporte') }}">Transporte</a>
        <a href="{{ route('reservas.create') }}">Reservar Ahora</a>
        <a href="{{ route('admin') }}">Panel Admin</a>
    </nav>

    @yield('content')

    <footer id="Contacto">
        <p>📍Playa Maya Bay</p>
        <p>📞 +52 55 73886630</p>
        <p>✉ contacto@mayabay.com</p>
        <p>© 2026 Maya Bay</p>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
