<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LibroVirtual;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LibroVirtualController extends Controller
{
    // LISTAR LIBROS
    public function index(Request $request)
    {
        $query = LibroVirtual::query();

        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%$search%")
                  ->orWhere('autor', 'like', "%$search%");
            });
        }

        $libros = $query->orderBy('titulo')->paginate(15);
        $categorias = Categoria::all();

        return view('admin.libros_virtuales.index', compact('libros', 'categorias'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.libros_virtuales.create', compact('categorias'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'resumen_sinopsis' => 'nullable|string',
            'url_archivo' => 'required|url',  
            'imagen_portada' => 'nullable|image|max:2048',
            'palabras_clave' => 'nullable|string',
        ]);

        $data = $request->all();

        // Subir portada
        if ($request->hasFile('imagen_portada')) {
            $data['imagen_portada'] = $request->file('imagen_portada')
                ->store('libros_virtuales', 'public');
        }

        // Peso archivo NULL por ser URL
        $data['peso_archivo'] = null;

        // Convertir cualquier URL de Google Drive a preview
        $data['url_archivo'] = $this->convertirDrivePreview($data['url_archivo']);

        LibroVirtual::create($data);

        return redirect()->route('admin.libros_virtuales.index')
            ->with('success', 'Libro virtual creado correctamente.');
    }

    // MOSTRAR
    public function show($id)
    {
        $libro = LibroVirtual::findOrFail($id);
        return view('admin.libros_virtuales.show', compact('libro'));
    }

    // FORMULARIO EDITAR
    public function edit($id)
    {
        $libro = LibroVirtual::findOrFail($id);
        $categorias = Categoria::all();

        return view('admin.libros_virtuales.edit', compact('libro', 'categorias'));
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $libro = LibroVirtual::findOrFail($id);

        $request->validate([
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'resumen_sinopsis' => 'nullable|string',
            'url_archivo' => 'required|url', 
            'imagen_portada' => 'nullable|image|max:2048',
            'palabras_clave' => 'nullable|string',
            'peso_archivo' => 'nullable|numeric|min:1',
            
        ]);

        $data = $request->all();

        // Reemplazo portada
        if ($request->hasFile('imagen_portada')) {
            if ($libro->imagen_portada) {
                Storage::disk('public')->delete($libro->imagen_portada);
            }
            $data['imagen_portada'] = $request->file('imagen_portada')
                ->store('libros_virtuales', 'public');
        }

                // Guardar el peso del archivo ingresado manualmente
        if ($request->filled('peso_archivo')) {
            $data['peso_archivo'] = $request->peso_archivo;
        } else {
            // Mantiene el peso ya existente si no se modifica
            $data['peso_archivo'] = $libro->peso_archivo;
        }

        // Convertir cualquier URL de Google Drive a preview
        $data['url_archivo'] = $this->convertirDrivePreview($data['url_archivo']);

        $libro->update($data);

        return redirect()->route('admin.libros_virtuales.index')
            ->with('success', 'Libro virtual actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy($id)
    {
        $libro = LibroVirtual::findOrFail($id);

        if ($libro->imagen_portada) {
            Storage::disk('public')->delete($libro->imagen_portada);
        }

        $libro->delete();

        return redirect()->route('admin.libros_virtuales.index')
            ->with('success', 'Libro virtual eliminado correctamente.');
    }

    // GENERAR TOKEN DE ACCESO
    public function generarAcceso($id_libro, $dni_usuario)
    {
        $libro = LibroVirtual::findOrFail($id_libro);

        $token = Str::random(40);

        $libro->accesosVirtuales()->create([
            'dni_usuario' => $dni_usuario,
            'token_seguridad' => $token,
            'fecha_generacion' => now(),
            'fecha_caducidad' => now()->addDays(7), // Token válido 7 días
            'estado' => 'ACTIVO',
        ]);

        return $token;
    }

    /**
     * Convertir cualquier URL de Google Drive a /preview válido
     */
    private function convertirDrivePreview($url)
    {
        if (str_contains($url, 'drive.google.com')) {
            // Extraer ID del archivo
            preg_match('/(?:\/d\/|id=)([a-zA-Z0-9_-]+)/', $url, $matches);
            if (!empty($matches[1])) {
                $id = $matches[1];
                return "https://drive.google.com/file/d/{$id}/preview";
            }
        }
        // Si no es Drive, devolver la URL original
        return $url;
    }
}
