<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LibroFisico;
use App\Models\LibroVirtual;
use App\Models\Categoria;
use App\Models\Reserva;      // 🔥 AGREGADO
use Illuminate\Support\Facades\Auth;

class CatalogoController extends Controller
{
    /**
     * 📚 Mostrar catálogo completo
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $categoriaId = $request->input('categoria');

        // 📌 Cargar todas las categorías
        $categorias = Categoria::orderBy('nombre_categoria')->get();

        // 📘 LIBROS VIRTUALES
        $librosVirtuales = LibroVirtual::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q2) use ($query) {
                    $q2->where('titulo', 'like', "%{$query}%")
                        ->orWhere('autor', 'like', "%{$query}%")
                        ->orWhere('palabras_clave', 'like', "%{$query}%");
                });
            })
            ->when($categoriaId, function ($q) use ($categoriaId) {
                $q->where('id_categoria', $categoriaId);
            })
            ->paginate(12, ['*'], 'virtuales');

        // 📗 LIBROS FÍSICOS
        $librosFisicos = LibroFisico::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q2) use ($query) {
                    $q2->where('titulo', 'like', "%{$query}%")
                        ->orWhere('autor', 'like', "%{$query}%")
                        ->orWhere('palabras_clave', 'like', "%{$query}%");
                });
            })
            ->when($categoriaId, function ($q) use ($categoriaId) {
                $q->where('id_categoria', $categoriaId);
            })
            ->where('stock_disponible', '>', 0)
            ->paginate(12, ['*'], 'fisicos');

        return view('alumno.catalogo.index', compact(
            'librosVirtuales',
            'librosFisicos',
            'categorias',
            'query',
            'categoriaId'
        ));
    }

    /**
     * 📘 Ver detalles de un libro virtual
     */
    public function showVirtual($id)
    {
        $libro = LibroVirtual::findOrFail($id);
        return view('alumno.catalogo.show_virtual', compact('libro'));
    }

    /**
     * 📗 Ver detalles de un libro físico
     */
    public function showFisico($id)
    {
        $libro = LibroFisico::findOrFail($id);

        // 🔥 Verificar si el alumno YA TIENE una reserva activa de cualquier libro
        $yaTieneReserva = Reserva::where('dni_usuario', Auth::user()->dni)
            ->where('estado', 'ACTIVA')
            ->exists();

        return view('alumno.catalogo.show_fisico', compact('libro', 'yaTieneReserva'));
    }
}
