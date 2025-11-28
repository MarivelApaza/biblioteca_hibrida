<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\LibroFisico;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * 🔹 Eliminar automáticamente reservas vencidas (1 día)
     */
    private function eliminarReservasVencidas($dni)
    {
        $hoy = Carbon::now();

        $reservasVencidas = Reserva::where('dni_usuario', $dni)
            ->where('estado', 'ACTIVA')
            ->whereDate('fecha_limite_recojo', '<', $hoy)
            ->get();

        foreach ($reservasVencidas as $reserva) {
            // Devolver stock
            LibroFisico::where('id_libro_fisico', $reserva->id_libro_fisico)
                ->increment('stock_disponible');

            // Eliminar reserva vencida
            $reserva->delete();
        }
    }

    /**
     * 🔹 Mostrar todas las reservas del alumno
     */
    public function index()
    {
        $dni = Auth::user()->dni;

        // Limpiar vencidas
        $this->eliminarReservasVencidas($dni);

        $reservas = Reserva::where('dni_usuario', $dni)
            ->with('libroFisico')
            ->orderBy('fecha_reserva', 'desc')
            ->get();

        return view('alumno.reservas.index', compact('reservas'));
    }

    /**
     * 🔹 Formulario de reserva
     */
    public function create($id_libro_fisico)
    {
        $dni = Auth::user()->dni;
        $libro = LibroFisico::findOrFail($id_libro_fisico);

        // Limpiar vencidas
        $this->eliminarReservasVencidas($dni);

        // Stock insuficiente
        if ($libro->stock_disponible < 1) {
            return redirect()->back()->withErrors('No hay stock disponible para este libro.');
        }

        // Verificar si ya tiene una reserva activa del mismo libro
        $existe = Reserva::where('dni_usuario', $dni)
            ->where('id_libro_fisico', $id_libro_fisico)
            ->where('estado', 'ACTIVA')
            ->exists();

        if ($existe) {
            return redirect()
                ->route('alumno.catalogo.showFisico', $id_libro_fisico)
                ->with('alerta', 'Ya tienes una reserva activa para este libro.');
        }

        return view('alumno.reservas.create', compact('libro'));
    }

    /**
     * 🔹 Guardar nueva reserva
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_libro_fisico' => 'required|exists:libros_fisicos,id_libro_fisico',
        ]);

        $dni = Auth::user()->dni;

        // Limpiar vencidas
        $this->eliminarReservasVencidas($dni);

        $libro = LibroFisico::findOrFail($request->id_libro_fisico);

        // Stock insuficiente
        if ($libro->stock_disponible < 1) {
            return redirect()->back()->withErrors('No hay stock disponible para este libro.');
        }

        // Verificar si ya tiene una reserva activa del mismo libro
        $existe = Reserva::where('dni_usuario', $dni)
            ->where('id_libro_fisico', $libro->id_libro_fisico)
            ->where('estado', 'ACTIVA')
            ->exists();

        if ($existe) {
            return redirect()
                ->route('alumno.catalogo.showFisico', $libro->id_libro_fisico)
                ->with('alerta', 'Ya tienes una reserva activa de este libro.');
        }

        // Crear reserva válida por 1 día
        Reserva::create([
            'dni_usuario'         => $dni,
            'id_libro_fisico'     => $libro->id_libro_fisico,
            'fecha_reserva'       => Carbon::now(),
            'fecha_limite_recojo' => Carbon::now()->addDay(),
            'estado'              => 'ACTIVA',
        ]);

        // Reducir stock
        $libro->decrement('stock_disponible');

        return redirect()
            ->route('alumno.reservas.index')
            ->with('success', 'Reserva creada correctamente. Tienes 1 día para recoger el libro.');
    }

    /**
     * 🔹 Mostrar detalles
     */
    public function show($id_reserva)
    {
        $dni = Auth::user()->dni;

        $this->eliminarReservasVencidas($dni);

        $reserva = Reserva::with('libroFisico')->findOrFail($id_reserva);

        if ($reserva->dni_usuario !== $dni) {
            abort(403);
        }

        return view('alumno.reservas.show', compact('reserva'));
    }

    /**
     * 🔹 Cancelar / eliminar reserva
     */
    public function destroy($id_reserva)
    {
        $dni = Auth::user()->dni;

        $reserva = Reserva::findOrFail($id_reserva);

        if ($reserva->dni_usuario !== $dni) {
            abort(403);
        }

        // Devolver stock
        LibroFisico::where('id_libro_fisico', $reserva->id_libro_fisico)
            ->increment('stock_disponible');

        // Eliminar reserva
        $reserva->delete();

        return redirect()
            ->route('alumno.reservas.index')
            ->with('success', 'Reserva cancelada correctamente.');
    }
}
