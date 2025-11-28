<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccesoVirtual;
use App\Models\LibroVirtual;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccesoVirtualController extends Controller
{
    /**
     * LISTAR ACCESOS
     */
    public function index()
    {
        $accesos = AccesoVirtual::with('libroVirtual')
            ->where('dni_usuario', auth()->user()->dni)
            ->orderBy('fecha_generacion', 'desc')
            ->get();

        return view('alumno.accesos.index', compact('accesos'));
    }

    /**
     * MOSTRAR DETALLE DE UN ACCESO
     */
    public function show($id)
    {
        $acceso = AccesoVirtual::with('libroVirtual')->findOrFail($id);

        if ($acceso->dni_usuario !== auth()->user()->dni) {
            abort(403, 'No tienes permiso para ver este acceso.');
        }

        return view('alumno.accesos.show', compact('acceso'));
    }

    /**
     * GENERAR ACCESO VIRTUAL (un solo acceso activo por libro)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_libro_virtual' => 'required|exists:libros_virtuales,id_libro_virtual'
        ]);

        $idLibro = $request->id_libro_virtual;
        $dni = auth()->user()->dni;

        // Revisa si ya existe un acceso activo
        $existe = AccesoVirtual::where('dni_usuario', $dni)
            ->where('id_libro_virtual', $idLibro)
            ->where('estado', 'ACTIVO')
            ->first();

        if ($existe) {
            return redirect()
                ->route('alumno.accesos.show', $existe->id_acceso_virtual)
                ->with('info', 'Ya generaste un acceso para este libro. Debes esperar a que expire.');
        }

        // Crear acceso nuevo con token UUID
        $token = Str::uuid();

        $acceso = AccesoVirtual::create([
            'dni_usuario'       => $dni,
            'id_libro_virtual'  => $idLibro,
            'token_seguridad'   => $token,
            'fecha_generacion'  => now(),

            // ⛔ TOKEN EXPIRA EN 1 MINUTO (SOLO PARA PRUEBAS)
            'fecha_caducidad'   => now()->addMinute(),

            // ✔️ Cuando termines tus pruebas, vuelve a:
            // 'fecha_caducidad'   => now()->addDays(7),

            'estado'            => 'ACTIVO',
        ]);

        return redirect()
            ->route('alumno.accesos.show', $acceso->id_acceso_virtual)
            ->with('success', 'Acceso generado correctamente.');
    }

    /**
     * ACCEDER AL PDF POR TOKEN
     */
    public function accederPDF($token)
    {
        $acceso = AccesoVirtual::where('token_seguridad', $token)->first();

        if (!$acceso)
            abort(404, 'Token inválido.');

        // Seguridad: solo el dueño del token puede usarlo
        if ($acceso->dni_usuario !== auth()->user()->dni)
            abort(403, 'No puedes acceder a este archivo.');

        // Verificar si está caducado
        if (now()->greaterThan($acceso->fecha_caducidad)) {
            $acceso->update(['estado' => 'EXPIRADO']);
            abort(403, 'El acceso ha caducado.');
        }

        $libro = $acceso->libroVirtual;

        // 📌 SOPORTE PARA URL EXTERNAS (Drive, OneDrive, Mega)
        if (filter_var($libro->url_archivo, FILTER_VALIDATE_URL)) {
            return redirect()->away($libro->url_archivo);
        }

        // 📌 SI ES ARCHIVO LOCAL
        if (!Storage::exists($libro->url_archivo)) {
            abort(404, 'Archivo no encontrado en el servidor.');
        }

        return response()->file(storage_path('app/' . $libro->url_archivo));
    }
}
