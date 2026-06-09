@extends('layouts.app')

@section('title', 'Hotel Maya Bay - Inicio')

@section('content')
    <header>
        <div class="hero">
            <h1>Hotel Maya Bay</h1>
            <p>Lujo, comodidad y vistas inolvidables frente al mar.</p>
            <a href="{{ route('reservas.create') }}" class="btn">Reservar Ahora</a>
        </div>
    </header>

    <section id="Sobre Nosotros">
        <h2>Sobre Nosotros</h2>
        <p style="text-align:center; max-width:800px; margin:0 auto;">
            Maya Bay Resort ofrece una experiencia única junto al mar,
            combinando lujo, naturaleza y comodidad para todos nuestros huéspedes.
        </p>
    </section>

    <section id="Habitaciones">
        <h2>Habitaciones</h2>

        <div class="habitaciones">
            <div class="card">
                <img src="{{ asset('img/estandar.jpg') }}" alt="Habitación Estándar">
                <div class="card-content">
                    <h3>Habitación Estándar</h3>
                    <p>Ideal para viajeros que buscan comodidad y tranquilidad.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('img/familiar.jpg') }}" alt="Habitación Familiar">
                <div class="card-content">
                    <h3>Habitación Familiar</h3>
                    <p>Espacios amplios con vista panorámica al océano.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('img/premium.jpg') }}" alt="Suite Premium">
                <div class="card-content">
                    <h3>Suite Premium</h3>
                    <p>La mejor experiencia de lujo para nuestros huéspedes.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="Transporte">
        <h2>Transporte</h2>

        <div class="transporte">
            <div class="card">
                <img src="{{ asset('img/Transportes.jpg') }}" alt="Transporte">
                <div class="card-content">
                    <h3>Transporte para 6 personas</h3>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('img/Taxi.png') }}" alt="Taxi de lujo">
                <div class="card-content">
                    <h3>Carro para 3 personas</h3>
                </div>
            </div>
        </div>
    </section>
@endsection
