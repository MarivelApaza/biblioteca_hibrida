<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AccesoVirtual;
use App\Models\LibroVirtual;

class AccesoVirtualController extends Controller
{
    public function index()
    {
        $dni = Auth::user()->dni;

        $accesos = AccesoVirtual::where('dni_usuario', $dni)
            ->with('libroVirtual')
            ->orderBy('fecha_generacion', 'desc')
            ->get();

        return view('alumno.accesos.index', compact('accesos'));
    }

    public function create($libro_id)
    {
        $libro = LibroVirtual::findOrFail($libro_id);
        return view('alumno.accesos.create', compact('libro'));
    }

    /**
     * 🧩 Generar token válido por 7 días (PRODUCCIÓN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_libro_virtual' => 'required|exists:libros_virtuales,id_libro_virtual',
        ]);

        $dni = Auth::user()->dni;
        $idLibro = $request->id_libro_virtual;

        // ¿Ya existe un acceso activo para este libro?
        $yaExiste = AccesoVirtual::where('dni_usuario', $dni)
            ->where('id_libro_virtual', $idLibro)
            ->where('estado', 'ACTIVO')
            ->where('fecha_caducidad', '>', now())
            ->first();

        if ($yaExiste) {
            return redirect()
                ->route('alumno.accesos.index')
                ->with('error', 'Ya generaste un acceso activo para este libro.');
        }

        // Crear token
        $token = Str::uuid();

        AccesoVirtual::create([
            'dni_usuario'      => $dni,
            'id_libro_virtual' => $idLibro,
            'token_seguridad'  => $token,
            'fecha_generacion' => now(),
            // ⏳ Caducidad REAL de 7 días
            'fecha_caducidad'  => now()->addDays(7),
            'estado'           => 'ACTIVO',
        ]);

        return redirect()
            ->route('alumno.accesos.index')
            ->with('success', 'Acceso virtual generado por 7 días.');
    }

    public function show($id)
    {
        $acceso = AccesoVirtual::with('libroVirtual')->findOrFail($id);

        if ($acceso->dni_usuario !== Auth::user()->dni) {
            abort(403, 'No autorizado.');
        }

        return view('alumno.accesos.show', compact('acceso'));
    }

    /**
     * 📂 Abrir visor del PDF
     */
    public function accederPDF($token)
    {
        $acceso = AccesoVirtual::with('libroVirtual')
            ->where('token_seguridad', $token)
            ->first();

        // Token inválido
        if (!$acceso) {
            return view('alumno.accesos.expirado')->with('mensaje', 'El acceso no existe o ya venció.');
        }

        // No pertenece al usuario
        if ($acceso->dni_usuario !== Auth::user()->dni) {
            return view('alumno.accesos.expirado')->with('mensaje', 'No tienes permiso para acceder a este recurso.');
        }

        // Caducado o inactivo
        if (now()->gt($acceso->fecha_caducidad) || $acceso->estado !== 'ACTIVO') {

            // 🔥Eliminar acceso caducado automáticamente
            $acceso->delete();

            return view('alumno.accesos.expirado')->with('mensaje', 'El acceso ha expirado.');
        }

        // 📄 URL real del PDF
        $urlPDF = $acceso->libroVirtual->url_archivo;

        return view('alumno.accesos.visor', compact('urlPDF'));
    }

    public function destroy($id)
    {
        $acceso = AccesoVirtual::findOrFail($id);

        if ($acceso->dni_usuario !== Auth::user()->dni) {
            abort(403, 'No autorizado.');
        }

        $acceso->delete();

        return redirect()
            ->route('alumno.accesos.index')
            ->with('success', 'Acceso virtual eliminado correctamente.');
    }
}
