@extends('layouts.app')

@section('title', 'Sobre Nosotros - Hotel Maya Bay')

@section('content')
    <main class="sobre-banner">
        <div class="overlay">
            <h1>Sobre Nosotros</h1>
            <p>
                Maya Bay Resort ofrece una experiencia única junto al mar,
                combinando lujo, naturaleza y comodidad para todos nuestros huéspedes.
            </p>
            <p>
                Nuestro hotel cuenta con vistas inigualables y un servicio exclusivo que le hará
                sentirse como en casa desde el primer momento. Disfrute de nuestra playa privada,
                restaurantes gourmet y una amplia gama de actividades diseñadas para toda la familia.
            </p>
            <p>
                Fundado con el objetivo de preservar el entorno natural de la bahía, Maya Bay es
                el destino perfecto para desconectarse y vivir unas vacaciones inolvidables.
            </p>
            <a href="{{ route('reservas.create') }}" class="btn">Reservar Ahora</a>
        </div>
    </main>
@endsection
