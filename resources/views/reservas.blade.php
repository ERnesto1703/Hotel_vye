@extends('layouts.app')

@section('title', 'Reservar en Línea - Hotel Maya Bay')

@section('styles')
<style>
    /* Ajustes específicos para integrarse con Bootstrap sin romper estilos personalizados */
    .reserva-container {
        padding: 40px 0;
    }
    .form-reserva {
        max-width: 800px !important;
        margin: auto;
    }
    .form-reserva label {
        margin-top: 15px;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
    <header class="banner-reservas">
        <div class="overlay">
            <h1>Reservaciones</h1>
            <p>Planifique su estadía ideal y asegure su lugar en el paraíso</p>
        </div>
    </header>

    <main class="container reserva-container">
        <div class="card shadow form-reserva p-4 border-0">
            <h2 class="text-center mb-4" style="color: #004d66;">Formulario de Reserva</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    <strong>🎉 ¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong class="d-block mb-2">⚠️ Hubo errores al procesar su solicitud:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('reservas.store') }}" method="POST">
                @csrf
                
                <h4 class="mb-3" style="color: #004d66; border-bottom: 2px solid #004d66; padding-bottom: 5px;">1. Datos del Cliente</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label font-weight-bold">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="cliente" value="{{ old('cliente') }}" placeholder="Nombre y Apellido" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label font-weight-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="cliente_email" value="{{ old('cliente_email') }}" placeholder="correo@ejemplo.com" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="telefono" class="form-label font-weight-bold">Número de Teléfono (10 dígitos)</label>
                        <input type="tel" class="form-control" id="telefono" name="cliente_telefono" value="{{ old('cliente_telefono') }}" placeholder="Ej. 5573886630" required>
                    </div>
                </div>

                <h4 class="mt-4 mb-3" style="color: #004d66; border-bottom: 2px solid #004d66; padding-bottom: 5px;">2. Detalles de la Habitación</h4>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="habitacion" class="form-label font-weight-bold">Tipo de Habitación</label>
                        <select class="form-select" id="habitacion" name="habitacion" required>
                            <option value="" disabled {{ !old('habitacion', request('type')) ? 'selected' : '' }}>Seleccione una habitación</option>
                            <option value="estandar" {{ old('habitacion', request('type')) == 'estandar' ? 'selected' : '' }}>Habitación Estándar ($120/noche)</option>
                            <option value="familiar" {{ old('habitacion', request('type')) == 'familiar' ? 'selected' : '' }}>Habitación Familiar ($180/noche)</option>
                            <option value="premium" {{ old('habitacion', request('type')) == 'premium' ? 'selected' : '' }}>Suite Premium ($280/noche)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="checkin" class="form-label font-weight-bold">Fecha de Entrada (Check-in)</label>
                        <input type="date" class="form-control" id="checkin" name="fecha_entrada" value="{{ old('fecha_entrada') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="checkout" class="form-label font-weight-bold">Fecha de Salida (Check-out)</label>
                        <input type="date" class="form-control" id="checkout" name="fecha_salida" value="{{ old('fecha_salida') }}" required>
                    </div>
                </div>

                <h4 class="mt-4 mb-3" style="color: #004d66; border-bottom: 2px solid #004d66; padding-bottom: 5px;">3. Traslado al Aeropuerto (Opcional)</h4>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="desea_traslado" name="desea_traslado" value="1" {{ old('desea_traslado') ? 'checked' : '' }} data-bs-toggle="collapse" data-bs-target="#seccion-traslado" aria-expanded="{{ old('desea_traslado') ? 'true' : 'false' }}">
                    <label class="form-check-label font-weight-bold" for="desea_traslado">¿Desea incluir servicio de traslado al aeropuerto?</label>
                </div>

                <div class="collapse {{ old('desea_traslado') ? 'show' : '' }} border rounded p-3 mb-4 bg-light" id="seccion-traslado">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tipo_traslado" class="form-label font-weight-bold">Tipo de Traslado</label>
                            <select class="form-select" id="tipo_traslado" name="traslado_tipo">
                                <option value="check-in" {{ old('traslado_tipo') == 'check-in' ? 'selected' : '' }}>Check-in (Aeropuerto -> Hotel)</option>
                                <option value="check-out" {{ old('traslado_tipo') == 'check-out' ? 'selected' : '' }}>Check-out (Hotel -> Aeropuerto)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora" class="form-label font-weight-bold">Fecha y Hora del Vuelo/Servicio</label>
                            <input type="datetime-local" class="form-control" id="fecha_hora" name="traslado_fecha_hora" value="{{ old('traslado_fecha_hora') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="num_pasajeros" class="form-label font-weight-bold">Número de Pasajeros</label>
                            <input type="number" class="form-control" id="num_pasajeros" name="traslado_num_pasajeros" value="{{ old('traslado_num_pasajeros') }}" min="1" max="10" placeholder="Ej. 2">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn text-white w-100 py-3 font-weight-bold" style="background-color: #004d66; border: none; border-radius: 5px;">Confirmar y Registrar Reservación</button>
            </form>
        </div>
    </main>
@endsection

@section('scripts')
<script>
    // Manejar el toggle del formulario para que los campos requeridos se habiliten/deshabiliten según el switch
    document.addEventListener('DOMContentLoaded', function() {
        const switchTraslado = document.getElementById('desea_traslado');
        const inputsTraslado = document.querySelectorAll('#seccion-traslado input, #seccion-traslado select');

        function toggleInputs() {
            const isChecked = switchTraslado.checked;
            inputsTraslado.forEach(input => {
                if (isChecked) {
                    if (input.id !== 'num_pasajeros' && input.id !== 'fecha_hora') return;
                    input.setAttribute('required', 'required');
                } else {
                    input.removeAttribute('required');
                }
            });
        }

        switchTraslado.addEventListener('change', toggleInputs);
        toggleInputs(); // Inicializar al cargar
    });
</script>
@endsection
