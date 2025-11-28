<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\PrestamoFisico;
use App\Models\LibroFisico;
use App\Models\Categoria;
use App\Models\User;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /** Listar reservas */
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'libroFisico.categoria'])
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);

        return view('admin.reservas.index', compact('reservas'));
    }

    /** Mostrar formulario de reserva */
    public function create(Request $request)
    {
        $categorias = Categoria::orderBy('nombre_categoria', 'asc')->get();

        $alumnos = User::where('rol', 'ALUMNO')
            ->where('estado', 'ACTIVO')
            ->orderBy('nombres', 'asc')
            ->get();

        $librosQuery = LibroFisico::with('categoria')->where('stock_disponible', '>', 0);

        if ($request->filled('categoria')) {
            $librosQuery->where('id_categoria', $request->categoria);
        }

        if ($request->filled('titulo')) {
            $librosQuery->where('titulo', 'like', "%{$request->titulo}%");
        }

        $libros = $librosQuery->orderBy('titulo', 'asc')->get();

        return view('admin.reservas.create', compact('categorias', 'alumnos', 'libros', 'request'));
    }

    /** Guardar nueva reserva */
    public function store(Request $request)
    {
        $request->validate([
            'dni_usuario' => 'required|exists:users,dni',
            'id_libro_fisico' => 'required|exists:libros_fisicos,id_libro_fisico',
            'fecha_limite_recojo' => 'required|date',
        ]);

        $libro = LibroFisico::findOrFail($request->id_libro_fisico);

        if ($libro->stock_disponible < 1) {
            return back()->with('error', 'Este libro no tiene stock disponible.');
        }

        Reserva::create([
            'dni_usuario' => $request->dni_usuario,
            'id_libro_fisico' => $request->id_libro_fisico,
            'fecha_reserva' => Carbon::now()->format('Y-m-d'),
            'fecha_limite_recojo' => $request->fecha_limite_recojo,
            'estado' => 'ACTIVA',
        ]);

        $libro->decrement('stock_disponible');

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva registrada correctamente.');
    }

    /** Ver detalle de reserva incluyendo datos del libro */
    public function show($id)
    {
        $reserva = Reserva::with(['usuario', 'libroFisico.categoria'])->findOrFail($id);

        // Ahora puedes acceder a:
        // $reserva->libroFisico->titulo
        // $reserva->libroFisico->codigo
        // $reserva->libroFisico->ubicacion
        // $reserva->libroFisico->categoria->nombre_categoria

        return view('admin.reservas.show', compact('reserva'));
    }

    /** Marcar reserva como completada */
    public function marcarCompletada($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update(['estado' => 'COMPLETADA']);
        $reserva->libroFisico->increment('stock_disponible');

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva marcada como completada.');
    }

    /** Expirar reserva */
    public function expirar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update(['estado' => 'EXPIRADA']);
        $reserva->libroFisico->increment('stock_disponible');

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva expirada.');
    }

    /** Eliminar reserva */
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado === 'ACTIVA') {
            $reserva->libroFisico->increment('stock_disponible');
        }

        $reserva->delete();

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva eliminada correctamente.');
    }

    /** Convertir reserva en préstamo automáticamente */
    public function convertirAPrestamo($id)
    {
        $reserva = Reserva::with('libroFisico', 'usuario')->findOrFail($id);

        if ($reserva->estado !== 'ACTIVA') {
            return redirect()->back()->with('error', 'La reserva ya no se puede convertir.');
        }

        $libro = $reserva->libroFisico;
        $usuario = $reserva->usuario;

        if ($libro->stock_disponible <= 0) {
            return redirect()->back()->with('error', 'No hay stock disponible para este libro.');
        }

        // Crear préstamo automáticamente
        PrestamoFisico::create([
            'dni_usuario' => $usuario->dni,
            'id_libro_fisico' => $libro->id_libro_fisico,
            'fecha_salida' => now(),
            'fecha_devolucion_programada' => now()->addDays(7),
            'estado' => 'PENDIENTE',
        ]);

        // Actualizar reserva
        $reserva->update(['estado' => 'COMPLETADA']);

        // Disminuir stock
        $libro->decrement('stock_disponible');

        return redirect()->route('admin.reservas.index')
            ->with('success', "Reserva convertida en préstamo correctamente. Libro prestado a {$usuario->nombres}.");
    }
}
