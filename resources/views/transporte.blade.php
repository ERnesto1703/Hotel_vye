@extends('layouts.app')

@section('title', 'Servicio de Transporte - Hotel Maya Bay')

@section('content')
    <header class="banner-transporte">
        <div class="overlay">
            <h1>Servicio de Transporte</h1>
            <p>Traslados cómodos, seguros y puntuales para su tranquilidad</p>
        </div>
    </header>

    <section class="descripcion-transporte">
        <h2>Viaje sin Preocupaciones</h2>
        <p style="font-size: 18px; line-height: 1.6; color: #555; max-width: 800px; margin: 20px auto 40px auto; text-align: center;">
            En Hotel Maya Bay nos encargamos de que su experiencia comience desde el momento en que llega a la ciudad. 
            Ofrecemos servicios de traslado privados desde el aeropuerto, visitas guiadas y alquiler de vehículos con conductor privado.
        </p>
    </section>

    <section style="padding: 40px 10%; background: #fdfdfd;">
        <h2 style="text-align: center; color: #004d66; margin-bottom: 30px;">Nuestra Flota</h2>
        <div class="vehiculos">
            <div class="card">
                <img src="{{ asset('img/Transportes.jpg') }}" alt="Van Ejecutiva">
                <div class="card-content">
                    <h3>Van Ejecutiva</h3>
                    <p style="margin-top: 10px; color: #666;">Espaciosa y cómoda, ideal para familias y grupos de hasta 6 personas con equipaje.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('img/Taxi.png') }}" alt="Auto de Lujo">
                <div class="card-content">
                    <h3>Auto de Lujo</h3>
                    <p style="margin-top: 10px; color: #666;">Vehículo elegante de gama alta para hasta 3 pasajeros. Perfecto para parejas y viajeros de negocios.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="beneficios" style="padding: 60px 10%;">
        <h2>Beneficios de Nuestro Servicio</h2>
        <div class="beneficios-grid">
            <div class="beneficio">
                <div style="font-size: 40px; margin-bottom: 10px;">🛡️</div>
                <h3>Seguridad</h3>
                <p style="margin-top: 10px; font-size: 14px; color: #666;">Conductores certificados y vehículos con seguro de cobertura total.</p>
            </div>
            <div class="beneficio">
                <div style="font-size: 40px; margin-bottom: 10px;">⏰</div>
                <h3>Puntualidad</h3>
                <p style="margin-top: 10px; font-size: 14px; color: #666;">Monitoreamos su vuelo para estar listos en el momento exacto de su arribo.</p>
            </div>
            <div class="beneficio">
                <div style="font-size: 40px; margin-bottom: 10px;">🥤</div>
                <h3>Comodidad</h3>
                <p style="margin-top: 10px; font-size: 14px; color: #666;">Vehículos con aire acondicionado, agua de cortesía y espacio para equipaje.</p>
            </div>
        </div>
    </section>
@endsection
