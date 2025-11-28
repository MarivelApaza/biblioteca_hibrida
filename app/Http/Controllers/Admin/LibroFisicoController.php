<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LibroFisico;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class LibroFisicoController extends Controller
{
    // Mostrar listado de libros físicos
    public function index(Request $request)
    {
        $query = LibroFisico::query();

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        // Búsqueda por título o autor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%$search%")
                  ->orWhere('autor', 'like', "%$search%");
            });
        }

        $libros = $query->orderBy('titulo')->paginate(15);
        $categorias = Categoria::all();

        return view('admin.libros_fisicos.index', compact('libros', 'categorias'));
    }

    // Formulario para crear un libro físico
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.libros_fisicos.create', compact('categorias'));
    }

    // Guardar libro físico
    public function store(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'editorial' => 'nullable|string|max:255',
            'año_edicion' => 'nullable|integer',
            'tipo_encuadernacion' => 'required|in:TAPA_DURA,RÚSTICA',
            'estado_promedio' => 'required|in:NUEVO,BUENO,REGULAR',
            'stock_total' => 'required|integer|min:0',
            'ubicacion_pasillo' => 'nullable|string|max:255',
            'imagen_portada' => 'nullable|image|max:2048',
            'palabras_clave' => 'nullable|string',
        ]);

        $data = $request->all();

        // Manejo de imagen de portada
        if ($request->hasFile('imagen_portada')) {
            $data['imagen_portada'] = $request->file('imagen_portada')->store('libros_fisicos', 'public');
        }

        // Inicializar stock disponible igual al stock total
        $data['stock_disponible'] = $data['stock_total'];

        LibroFisico::create($data);

        return redirect()->route('admin.libros_fisicos.index')
            ->with('success', 'Libro físico creado correctamente.');
    }

    // Mostrar libro específico
    public function show($id)
    {
        $libro = LibroFisico::findOrFail($id);
        return view('admin.libros_fisicos.show', compact('libro'));
    }

    // Formulario para editar libro
    public function edit($id)
    {
        $libro = LibroFisico::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.libros_fisicos.edit', compact('libro', 'categorias'));
    }

    // Actualizar libro físico
    public function update(Request $request, $id)
    {
        $libro = LibroFisico::findOrFail($id);

        $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'editorial' => 'nullable|string|max:255',
            'año_edicion' => 'nullable|integer',
            'tipo_encuadernacion' => 'required|in:TAPA_DURA,RÚSTICA',
            'estado_promedio' => 'required|in:NUEVO,BUENO,REGULAR',
            'stock_total' => 'required|integer|min:0',
            'ubicacion_pasillo' => 'nullable|string|max:255',
            'imagen_portada' => 'nullable|image|max:2048',
            'palabras_clave' => 'nullable|string',
        ]);

        $data = $request->all();

        // Manejo de imagen de portada
        if ($request->hasFile('imagen_portada')) {
            if ($libro->imagen_portada) {
                Storage::disk('public')->delete($libro->imagen_portada);
            }
            $data['imagen_portada'] = $request->file('imagen_portada')->store('libros_fisicos', 'public');
        }

        // Ajustar stock disponible si cambia stock_total
        if ($request->stock_total != $libro->stock_total) {
            $diff = $request->stock_total - $libro->stock_total;
            $data['stock_disponible'] = $libro->stock_disponible + $diff;
            if ($data['stock_disponible'] < 0) $data['stock_disponible'] = 0;
        }

        $libro->update($data);

        return redirect()->route('admin.libros_fisicos.index')
            ->with('success', 'Libro físico actualizado correctamente.');
    }

    // Eliminar libro físico
    public function destroy($id)
    {
        $libro = LibroFisico::findOrFail($id);

        // Borrar imagen si existe
        if ($libro->imagen_portada) {
            Storage::disk('public')->delete($libro->imagen_portada);
        }

        $libro->delete();

        return redirect()->route('admin.libros_fisicos.index')
            ->with('success', 'Libro físico eliminado correctamente.');
    }
}
