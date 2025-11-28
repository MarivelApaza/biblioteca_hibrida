<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\LibroFisico;
use App\Models\LibroVirtual;

class FavoritoController extends Controller
{
    /**
     * Listar todos los favoritos del estudiante
     */
    public function index()
    {
        $dni = Auth::user()->dni;

        // Traer favoritos del usuario con relaciones a libros según tipo
        $favoritos = Favorito::where('dni_usuario', $dni)
            ->with([
                'libroFisico',  // Relación a libros físicos
                'libroVirtual'  // Relación a libros virtuales
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('alumno.favoritos.index', compact('favoritos'));
    }

    /**
     * Agregar un recurso a favoritos
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_referencia' => 'required|integer',
            'tipo_recurso' => 'required|in:FISICO,VIRTUAL',
        ]);

        $dni = Auth::user()->dni;

        // Evitar duplicados
        $exists = Favorito::where('dni_usuario', $dni)
            ->where('id_referencia', $request->id_referencia)
            ->where('tipo_recurso', $request->tipo_recurso)
            ->first();

        if ($exists) {
            return redirect()->back()->with('info', 'Este recurso ya está en tus favoritos.');
        }

        // Crear favorito correctamente
        Favorito::create([
            'dni_usuario' => $dni,
            'id_referencia' => $request->id_referencia,
            'tipo_recurso' => $request->tipo_recurso,
        ]);

        return redirect()->back()->with('success', 'Recurso agregado a favoritos.');
    }

    /**
     * Eliminar un favorito
     */
    public function destroy($id)
    {
        $favorito = Favorito::findOrFail($id);

        // Solo el propietario puede eliminar
        if ($favorito->dni_usuario !== Auth::user()->dni) {
            abort(403, 'No tienes permiso para eliminar este favorito.');
        }

        $favorito->delete();

        return redirect()->back()->with('success', 'Favorito eliminado correctamente.');
    }

    /**
     * Función auxiliar para verificar si un recurso ya está en favoritos
     */
    public static function isFavorito($dni, $id_referencia, $tipo_recurso)
    {
        return Favorito::where('dni_usuario', $dni)
            ->where('id_referencia', $id_referencia)
            ->where('tipo_recurso', $tipo_recurso)
            ->exists();
    }
}
