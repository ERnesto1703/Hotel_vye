<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\Camioneta;
use App\Models\ReservaHabitacion;
use App\Models\ReservaTraslado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Display the about page.
     */
    public function sobreNosotros()
    {
        return view('sobre-nosotros');
    }

    /**
     * Display the transport page.
     */
    public function transporte()
    {
        return view('transporte');
    }

    /**
     * Display the admin panel dashboard.
     */
    public function admin()
    {
        $today = Carbon::today();
        
        // Fetch all rooms and determine if they are occupied today
        $habitaciones = Habitacion::all();
        foreach ($habitaciones as $hab) {
            $hab->reserva_hoy = ReservaHabitacion::where('habitacion_id', $hab->id)
                ->where('fecha_entrada', '<=', $today->format('Y-m-d'))
                ->where('fecha_salida', '>', $today->format('Y-m-d'))
                ->first();
        }

        $camionetas = Camioneta::all();
        $traslados = ReservaTraslado::with('reservaHabitacion')->get();

        return view('admin', compact('habitaciones', 'camionetas', 'traslados'));
    }

    /**
     * Display the rooms page with dynamic availability.
     */
    public function habitaciones()
    {
        $availability = $this->getAvailabilityData();

        return view('habitaciones', compact('availability'));
    }

    /**
     * Show the booking form.
     */
    public function createReserva()
    {
        return view('reservas');
    }

    /**
     * Store a new booking in the database (Room + optional Transfer).
     */
    public function storeReserva(Request $request)
    {
        // Custom messages in Spanish
        $messages = [
            'cliente.required' => 'El nombre completo es obligatorio.',
            'cliente.regex' => 'El nombre completo solo puede contener letras y espacios.',
            'cliente_email.required' => 'El correo electrónico es obligatorio.',
            'cliente_email.email' => 'Debe ingresar un correo electrónico válido.',
            'cliente_email.regex' => 'El correo electrónico debe terminar en .com.',
            'cliente_telefono.required' => 'El número de teléfono es obligatorio.',
            'cliente_telefono.regex' => 'El número de teléfono debe tener exactamente 10 dígitos numéricos.',
            'habitacion.required' => 'Debe seleccionar un tipo de habitación.',
            'habitacion.in' => 'El tipo de habitación seleccionado no es válido.',
            'fecha_entrada.required' => 'La fecha de entrada (check-in) es obligatoria.',
            'fecha_entrada.date' => 'La fecha de entrada no tiene un formato válido.',
            'fecha_entrada.after_or_equal' => 'La fecha de entrada no puede ser anterior a hoy.',
            'fecha_salida.required' => 'La fecha de salida (check-out) es obligatoria.',
            'fecha_salida.date' => 'La fecha de salida no tiene un formato válido.',
            'fecha_salida.after' => 'La fecha de salida (check-out) debe ser posterior a la fecha de entrada.',
            
            // Transfer errors
            'traslado_tipo.required_if' => 'El tipo de traslado es obligatorio si se solicita el servicio.',
            'traslado_tipo.in' => 'El tipo de traslado debe ser check-in o check-out.',
            'traslado_fecha_hora.required_if' => 'La fecha y hora del traslado es obligatoria si se solicita el servicio.',
            'traslado_num_pasajeros.required_if' => 'El número de pasajeros es obligatorio si se solicita el servicio.',
            'traslado_num_pasajeros.integer' => 'El número de pasajeros debe ser un número entero.',
            'traslado_num_pasajeros.min' => 'El número de pasajeros debe ser al menos 1.',
            'traslado_num_pasajeros.max' => 'El número máximo de pasajeros para un traslado es 10.',
        ];

        // Validate request data
        $validator = Validator::make($request->all(), [
            'cliente' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'cliente_email' => ['required', 'email', 'max:255', 'regex:/.*\.com$/i'],
            'cliente_telefono' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'habitacion' => 'required|in:estandar,familiar,premium',
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            
            // Optional transfer rules
            'desea_traslado' => 'nullable|in:1',
            'traslado_tipo' => 'required_if:desea_traslado,1|nullable|in:check-in,check-out',
            'traslado_fecha_hora' => 'required_if:desea_traslado,1|nullable|date',
            'traslado_num_pasajeros' => 'required_if:desea_traslado,1|nullable|integer|min:1|max:10',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $checkin = $request->fecha_entrada;
        $checkout = $request->fecha_salida;
        $type = $request->habitacion;

        // DB Transaction to guarantee both room and optional transfer are saved together
        return DB::transaction(function () use ($request, $checkin, $checkout, $type) {
            
            // 1. Find an available Room (of the 40 total)
            $rooms = Habitacion::where('tipo', $type)->get();
            $assignedRoom = null;

            foreach ($rooms as $room) {
                // Check overlap of dates
                $overlap = ReservaHabitacion::where('habitacion_id', $room->id)
                    ->where('fecha_entrada', '<', $checkout)
                    ->where('fecha_salida', '>', $checkin)
                    ->exists();

                if (!$overlap) {
                    $assignedRoom = $room;
                    break;
                }
            }

            if (!$assignedRoom) {
                return redirect()->back()
                    ->withErrors(['habitacion' => 'Lo sentimos, no hay habitaciones de tipo "' . ucfirst($type) . '" disponibles para las fechas seleccionadas.'])
                    ->withInput();
            }

            // 2. Check and Assign Shuttle (if requested)
            $assignedShuttle = null;
            if ($request->desea_traslado == '1') {
                $fechaHora = Carbon::parse($request->traslado_fecha_hora)->format('Y-m-d H:i:s');
                $numPasajeros = (int)$request->traslado_num_pasajeros;
                
                $shuttles = Camioneta::all();
                
                foreach ($shuttles as $shuttle) {
                    // Calculate sum of passengers currently assigned to this shuttle at this specific flight/service time
                    $currentPassengers = ReservaTraslado::where('camioneta_id', $shuttle->id)
                        ->where('fecha_hora', $fechaHora)
                        ->sum('num_pasajeros');
                    
                    if ($currentPassengers + $numPasajeros <= $shuttle->capacidad) {
                        $assignedShuttle = $shuttle;
                        break; // Assign this shuttle!
                    }
                }

                if (!$assignedShuttle) {
                    return redirect()->back()
                        ->withErrors(['desea_traslado' => 'Lo sentimos, no hay capacidad de transporte disponible en nuestras camionetas para el horario seleccionado (camionetas saturadas).'])
                        ->withInput();
                }
            }

            // 3. Save Room Reservation
            $reservaHab = ReservaHabitacion::create([
                'cliente' => $request->cliente,
                'cliente_email' => $request->cliente_email,
                'cliente_telefono' => $request->cliente_telefono,
                'habitacion_id' => $assignedRoom->id,
                'fecha_entrada' => $checkin,
                'fecha_salida' => $checkout,
            ]);

            // 4. Save Shuttle Reservation (if requested)
            if ($request->desea_traslado == '1' && $assignedShuttle) {
                ReservaTraslado::create([
                    'reserva_habitacion_id' => $reservaHab->id,
                    'camioneta_id' => $assignedShuttle->id,
                    'fecha_hora' => $request->traslado_fecha_hora,
                    'num_pasajeros' => $request->traslado_num_pasajeros,
                    'tipo' => $request->traslado_tipo,
                ]);
            }

            $successMsg = '¡Su reservación ha sido registrada con éxito! Asignado: ' . $assignedRoom->numero;
            if ($request->desea_traslado == '1' && $assignedShuttle) {
                $successMsg .= ' con servicio de traslado confirmado en Camioneta Placa ' . $assignedShuttle->placa . '.';
            }

            return redirect()->route('reservas.create')
                ->with('success', $successMsg);
        });
    }

    /**
     * Helper function to calculate today's availability and next available date.
     */
    private function getAvailabilityData()
    {
        $types = ['estandar', 'familiar', 'premium'];
        $availability = [];
        $today = Carbon::today();

        foreach ($types as $type) {
            $rooms = Habitacion::where('tipo', $type)->get();
            $earliest_free_dates = [];
            $available_count = 0;

            foreach ($rooms as $room) {
                $date = $today->copy();
                
                // Keep checking contiguous overlapping bookings
                while (true) {
                    $overlapping = ReservaHabitacion::where('habitacion_id', $room->id)
                        ->where('fecha_entrada', '<=', $date->format('Y-m-d'))
                        ->where('fecha_salida', '>', $date->format('Y-m-d'))
                        ->first();
                    
                    if ($overlapping) {
                        $date = Carbon::parse($overlapping->fecha_salida);
                    } else {
                        break;
                    }
                }
                
                $earliest_free_dates[] = $date;
                
                if ($date->equalTo($today)) {
                    $available_count++;
                }
            }

            // Next available date is the minimum release date across all rooms
            $next_available = collect($earliest_free_dates)->min();

            $availability[$type] = [
                'available_count' => $available_count,
                'next_available_date' => $next_available->format('Y-m-d'),
            ];
        }

        return $availability;
    }
}
