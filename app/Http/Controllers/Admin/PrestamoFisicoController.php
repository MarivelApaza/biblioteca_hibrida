<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrestamoFisico;
use App\Models\Reserva;
use App\Models\LibroFisico;
use App\Models\User;
use Carbon\Carbon;

class PrestamoFisicoController extends Controller
{
    /** Listar todos los préstamos físicos */
    public function index(Request $request)
    {
        $query = PrestamoFisico::with(['usuario', 'libroFisico.categoria']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $prestamos = $query->orderBy('fecha_salida', 'desc')->paginate(20);
        return view('admin.prestamos_fisicos.index', compact('prestamos'));
    }

    /** Mostrar formulario de creación de préstamo */
    public function create(Request $request)
    {
        $usuarios = User::where('rol', 'ALUMNO')->where('estado', 'ACTIVO')->orderBy('nombres')->get();
        $libros = LibroFisico::where('stock_disponible', '>', 0)->orderBy('titulo')->get();
        $dni_selected = $nombre_selected = null;

        if ($request->filled('alumno')) {
            $partes = explode(" - ", $request->alumno);
            $dni_selected = $partes[0] ?? null;
            $nombre_selected = $partes[1] ?? null;
        }

        return view('admin.prestamos_fisicos.create', compact('usuarios', 'libros', 'dni_selected', 'nombre_selected'));
    }

    /** Guardar nuevo préstamo */
    public function store(Request $request)
    {
        $request->validate([
            'dni_usuario' => 'required|exists:users,dni',
            'id_libro_fisico' => 'required|exists:libros_fisicos,id_libro_fisico',
            'fecha_devolucion_programada' => 'required|date|after_or_equal:today',
        ]);

        $usuario = User::findOrFail($request->dni_usuario);
        if ($usuario->estado === 'SANCIONADO') {
            return back()->withErrors(['dni_usuario' => 'El usuario está sancionado y no puede prestar libros.']);
        }

        $libro = LibroFisico::findOrFail($request->id_libro_fisico);
        if ($libro->stock_disponible <= 0) {
            return back()->withErrors(['id_libro_fisico' => 'No hay stock disponible para este libro.']);
        }

        $prestamo = PrestamoFisico::create([
            'dni_usuario' => $usuario->dni,
            'id_libro_fisico' => $libro->id_libro_fisico,
            'fecha_salida' => Carbon::now(),
            'fecha_devolucion_programada' => $request->fecha_devolucion_programada,
            'estado' => 'PENDIENTE',
        ]);

        $libro->decrement('stock_disponible');

        $reserva = Reserva::where('dni_usuario', $usuario->dni)
                          ->where('id_libro_fisico', $libro->id_libro_fisico)
                          ->where('estado', 'ACTIVA')
                          ->first();
        if ($reserva) $reserva->update(['estado' => 'COMPLETADA']);

        return redirect()->route('admin.prestamos_fisicos.index')
                         ->with('success', "Préstamo físico registrado correctamente.");
    }

    /** Mostrar formulario de devolución */
    public function devolverForm($id)
    {
        $prestamo = PrestamoFisico::with(['usuario', 'libroFisico'])->findOrFail($id);

        if ($prestamo->estado !== 'PENDIENTE') {
            return redirect()->route('admin.prestamos_fisicos.index')
                             ->with('error', 'Este préstamo ya fue devuelto o está en mora.');
        }

        return view('admin.prestamos_fisicos.devolver', compact('prestamo'));
    }

    /** Guardar devolución desde formulario */
    public function devolver(Request $request, $id)
    {
        $prestamo = PrestamoFisico::with(['usuario', 'libroFisico'])->findOrFail($id);

        $request->validate([
            'fecha_devolucion_real' => 'required|date|after_or_equal:' . $prestamo->fecha_salida,
            'observaciones_devolucion' => 'nullable|string',
        ]);

        $prestamo->update([
            'fecha_devolucion_real' => $request->fecha_devolucion_real,
            'observaciones_devolucion' => $request->observaciones_devolucion,
            'estado' => 'DEVUELTO',
        ]);

        // Aumentar stock
        $prestamo->libroFisico->increment('stock_disponible');

        // Liberar sanción si existía
        if ($prestamo->usuario->estado === 'SANCIONADO') {
            $prestamo->usuario->update(['estado' => 'ACTIVO']);
        }

        return redirect()->route('admin.prestamos_fisicos.index')
                         ->with('success', 'Libro marcado como devuelto correctamente.');
    }

    /** Mostrar detalle del préstamo */
    public function show($id)
    {
        $prestamo = PrestamoFisico::with(['usuario', 'libroFisico.categoria'])->findOrFail($id);
        return view('admin.prestamos_fisicos.show', compact('prestamo'));
    }

    /** Editar préstamo (observaciones) */
    public function edit($id)
    {
        $prestamo = PrestamoFisico::with(['usuario', 'libroFisico'])->findOrFail($id);
        return view('admin.prestamos_fisicos.edit', compact('prestamo'));
    }

    /** Actualizar préstamo (observaciones) */
    public function update(Request $request, $id)
    {
        $prestamo = PrestamoFisico::findOrFail($id);

        $request->validate([
            'observaciones_devolucion' => 'nullable|string',
        ]);

        $prestamo->update([
            'observaciones_devolucion' => $request->observaciones_devolucion,
        ]);

        return redirect()->route('admin.prestamos_fisicos.index')
                         ->with('success', 'Préstamo actualizado correctamente.');
    }

    /** Eliminar préstamo físico */
    public function destroy($id)
    {
        $prestamo = PrestamoFisico::findOrFail($id);

        if ($prestamo->estado === 'PENDIENTE') {
            $prestamo->libroFisico->increment('stock_disponible');
        }

        $prestamo->delete();

        return redirect()->route('admin.prestamos_fisicos.index')
                         ->with('success', 'Préstamo físico eliminado correctamente.');
    }
}
