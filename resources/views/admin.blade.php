@extends('layouts.app')

@section('title', 'Panel de Administración - Hotel Maya Bay')

@section('styles')
<style>
    .admin-container {
        padding: 40px 0;
    }
    .badge-ocupada {
        background-color: #dc3545;
        color: white;
    }
    .badge-disponible {
        background-color: #28a745;
        color: white;
    }
</style>
@endsection

@section('content')
    <header class="banner-habitaciones" style="height: 30vh; background-image: url('{{ asset('img/habitaciones.jpg') }}');">
        <div class="overlay">
            <h1>Panel de Administración</h1>
            <p>Monitoreo de ocupación de habitaciones y agenda de camionetas</p>
        </div>
    </header>

    <main class="container admin-container">
        
        <!-- Tarjetas de Resumen -->
        <div class="row mb-5 text-center">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm p-4 bg-light">
                    <h5 class="text-muted">Habitaciones Ocupadas Hoy</h5>
                    <h2 class="display-5 font-weight-bold" style="color: #004d66;">
                        {{ $habitaciones->filter(fn($h) => $h->reserva_hoy !== null)->count() }} / 40
                    </h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm p-4 bg-light">
                    <h5 class="text-muted">Habitaciones Disponibles</h5>
                    <h2 class="display-5 font-weight-bold text-success">
                        {{ 40 - $habitaciones->filter(fn($h) => $h->reserva_hoy !== null)->count() }}
                    </h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm p-4 bg-light">
                    <h5 class="text-muted">Traslados Programados</h5>
                    <h2 class="display-5 font-weight-bold text-primary">
                        {{ $traslados->count() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sección de Habitaciones (Grid de 40 Habitaciones) -->
            <div class="col-lg-6 mb-5">
                <div class="card shadow border-0 p-4">
                    <h3 class="mb-4" style="color: #004d66; border-bottom: 2px solid #004d66; padding-bottom: 5px;">🏨 Estado de Habitaciones (40)</h3>
                    <p class="text-muted small">Estado en tiempo real para el día de hoy ({{ \Carbon\Carbon::today()->format('d/m/Y') }}).</p>
                    
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nro / Tipo</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($habitaciones as $hab)
                                    <tr>
                                        <td>
                                            <strong>{{ $hab->numero }}</strong>
                                            <div class="text-muted small">{{ ucfirst($hab->tipo) }}</div>
                                        </td>
                                        <td>${{ number_format($hab->precio, 0) }}</td>
                                        <td>
                                            @if($hab->reserva_hoy)
                                                <span class="badge badge-ocupada p-2">Ocupada</span>
                                            @else
                                                <span class="badge badge-disponible p-2">Disponible</span>
                                            @endif
                                        </td>
                                        <td class="small">
                                            @if($hab->reserva_hoy)
                                                <strong>Huésped:</strong> {{ $hab->reserva_hoy->cliente }} <br>
                                                <strong>Salida:</strong> {{ \Carbon\Carbon::parse($hab->reserva_hoy->fecha_salida)->format('d/m/Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sección de Traslados (Agenda de las 3 Camionetas) -->
            <div class="col-lg-6 mb-5">
                <div class="card shadow border-0 p-4">
                    <h3 class="mb-4" style="color: #004d66; border-bottom: 2px solid #004d66; padding-bottom: 5px;">🚐 Agenda de las 3 Camionetas</h3>
                    <p class="text-muted small">Cronograma de traslados asignados a los vehículos oficiales del hotel.</p>
                    
                    @foreach($camionetas as $cam)
                        <div class="border rounded p-3 mb-4 bg-light shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0" style="color: #004d66;">🚐 Camioneta Placa: <strong>{{ $cam->placa }}</strong></h5>
                                <span class="badge bg-secondary p-2">Capacidad: {{ $cam->capacidad }} pax</span>
                            </div>
                            
                            @php
                                $trasladosCamioneta = $traslados->where('camioneta_id', $cam->id)->sortBy('fecha_hora');
                            @endphp

                            @if($trasladosCamioneta->isEmpty())
                                <p class="text-muted small mb-0">No hay traslados programados para este vehículo.</p>
                            @else
                                <div class="list-group list-group-flush rounded border mt-2">
                                    @foreach($trasladosCamioneta as $tras)
                                        <div class="list-group-item list-group-item-action p-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Huésped: <strong>{{ $tras->reservaHabitacion->cliente }}</strong></h6>
                                                <small class="text-primary font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($tras->fecha_hora)->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <p class="mb-1 small">
                                                <strong>Pasajeros:</strong> {{ $tras->num_pasajeros }} <br>
                                                <strong>Servicio:</strong> 
                                                <span class="badge bg-info text-dark">{{ ucfirst($tras->tipo) }}</span>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </main>
@endsection
