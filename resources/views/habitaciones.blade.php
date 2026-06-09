@extends('layouts.app')

@section('title', 'Nuestras Habitaciones - Hotel Maya Bay')

@section('content')
    <header class="banner-habitaciones">
        <div class="overlay">
            <h1>Habitaciones</h1>
            <p>Comodidad, lujo y descanso garantizado frente al mar</p>
        </div>
    </header>

    <main class="contenedor-habitaciones">

        <!-- Habitación Estándar -->
        <div class="habitacion-card">
            <img src="{{ asset('img/estandar.jpg') }}" alt="Habitación Estándar">
            <div class="contenido">
                <h2>Habitación Estándar</h2>
                
                @if($availability['estandar']['available_count'] > 0)
                    <div style="color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 5px; font-weight: bold; margin-bottom: 15px; display: inline-block;">
                        🟢 Disponible hoy ({{ $availability['estandar']['available_count'] }} libres)
                    </div>
                @else
                    <div style="color: #c62828; background: #ffebee; padding: 10px; border-radius: 5px; font-weight: bold; margin-bottom: 15px; display: inline-block;">
                        🔴 Ocupado hoy (Siguiente disponible: {{ \Carbon\Carbon::parse($availability['estandar']['next_available_date'])->format('d/m/Y') }})
                    </div>
                @endif

                <ul>
                    <li>🛏️ 1 Cama Queen Size</li>
                    <li>📶 Wifi Gratuito de alta velocidad</li>
                    <li>📺 TV por cable y Smart TV</li>
                    <li>🚿 Baño privado con ducha caliente</li>
                    <li>❄️ Aire Acondicionado</li>
                </ul>
                <div class="precio">$120 / Noche</div>
                <a href="{{ route('reservas.create', ['type' => 'estandar']) }}" class="btn">Reservar Ahora</a>
            </div>
        </div>

        <!-- Habitación Familiar -->
        <div class="habitacion-card">
            <img src="{{ asset('img/familiar.jpg') }}" alt="Habitación Familiar">
            <div class="contenido">
                <h2>Habitación Familiar</h2>

                @if($availability['familiar']['available_count'] > 0)
                    <div style="color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 5px; font-weight: bold; margin-bottom: 15px; display: inline-block;">
                        🟢 Disponible hoy ({{ $availability['familiar']['available_count'] }} libres)
                    </div>
                @else
                    <div style="color: #c62828; background: #ffebee; padding: 10px; border-radius: 5px; font-weight: bold; margin-bottom: 15px; display: inline-block;">
                        🔴 Ocupado hoy (Siguiente disponible: {{ \Carbon\Carbon::parse($availability['familiar']['next_available_date'])->format('d/m/Y') }})
                    </div>
                @endif

                <ul>
                    <li>🛏️ 2 Camas Queen Size</li>
                    <li>📶 Wifi Gratuito de alta velocidad</li>
                    <li>📺 Smart TV de 55"</li>
                    <li>🌊 Balcón privado con vista parcial</li>
                    <li>🍳 Minibar y microondas</li>
                </ul>
                <div class="precio">$180 / Noche</div>
                <a href="{{ route('reservas.create', ['type' => 'familiar']) }}" class="btn">Reservar Ahora</a>
            </div>
        </div>

        <!-- Suite Premium -->
        <div class="habitacion-card">
            <img src="{{ asset('img/premium.jpg') }}" alt="Suite Premium">
            <div class="contenido">
                <h2>Suite Premium</h2>

                @if($availability['premium']['available_count'] > 0)
                    <div style="color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 5px; font-weight: bold; margin-bottom: 15px; display: inline-block;">
                        🟢 Disponible hoy ({{ $availability['premium']['available_count'] }} libres)
                    </div>
                @else
                    <div style="color: #c62828; background: #ffebee; padding: 10px; border-radius: 5px; font-weight: bold; margin-bottom: 15px; display: inline-block;">
                        🔴 Ocupado hoy (Siguiente disponible: {{ \Carbon\Carbon::parse($availability['premium']['next_available_date'])->format('d/m/Y') }})
                    </div>
                @endif

                <ul>
                    <li>🛏️ 1 Cama King Size Extra Comfort</li>
                    <li>📶 Wifi Gratuito de alta velocidad</li>
                    <li>🌅 Vista panorámica frontal al océano</li>
                    <li>🛁 Jacuzzi privado en la terraza</li>
                    <li>🍾 Botella de bienvenida y servicio al cuarto 24/7</li>
                </ul>
                <div class="precio">$280 / Noche</div>
                <a href="{{ route('reservas.create', ['type' => 'premium']) }}" class="btn">Reservar Ahora</a>
            </div>
        </div>

    </main>
@endsection
