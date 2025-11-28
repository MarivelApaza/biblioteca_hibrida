<?php
namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apunte;
use App\Models\LibroVirtual;
use Illuminate\Support\Facades\Auth;

class ApunteController extends Controller
{
    // 📖 Listar apuntes del alumno
    public function index()
    {
        $apuntes = Apunte::misApuntes(); // Scope personalizado
        return view('alumno.apuntes.index', compact('apuntes'));
    }

    // 📝 Mostrar lista de libros para elegir
    public function seleccionarLibro()
    {
        $libros = LibroVirtual::all(); // Todos los libros
        return view('alumno.apuntes.seleccionar', compact('libros'));
    }

    // ➕ Crear nuevo apunte
    public function create(Request $request)
    {
        $libros = LibroVirtual::all(); // Todos los libros

        // Libro seleccionado por defecto (opcional)
        $libroSeleccionado = null;
        if ($request->has('id_libro')) {
            $libroSeleccionado = LibroVirtual::find($request->id_libro);
        }

        return view('alumno.apuntes.create', compact('libros', 'libroSeleccionado'));
    }

    // 💾 Guardar apunte
    public function store(Request $request)
    {
        $request->validate([
            'id_libro_virtual' => 'required|integer',
            'pagina_pdf'       => 'nullable|integer',
            'texto_nota'       => 'required|string',
        ]);

        Apunte::create([
            'dni_usuario'      => Auth::user()->dni,
            'id_libro_virtual' => $request->id_libro_virtual,
            'pagina_pdf'       => $request->pagina_pdf,
            'texto_nota'       => $request->texto_nota,
        ]);

        return redirect()->route('alumno.apuntes.index')
                         ->with('success', 'Apunte guardado correctamente.');
    }

    // ✏️ Editar apunte
    public function edit($id)
    {
        $apunte = Apunte::findOrFail($id);
        if ($apunte->dni_usuario !== Auth::user()->dni) {
            abort(403);
        }
        return view('alumno.apuntes.edit', compact('apunte'));
    }

    // 💾 Actualizar apunte
    public function update(Request $request, $id)
    {
        $apunte = Apunte::findOrFail($id);
        if ($apunte->dni_usuario !== Auth::user()->dni) {
            abort(403);
        }

        $request->validate([
            'pagina_pdf' => 'nullable|integer',
            'texto_nota' => 'required|string',
        ]);

        $apunte->update([
            'pagina_pdf' => $request->pagina_pdf,
            'texto_nota' => $request->texto_nota,
        ]);

        return redirect()->route('alumno.apuntes.index')
                         ->with('success', 'Apunte actualizado correctamente.');
    }

    // 🗑️ Eliminar apunte
    public function destroy($id)
    {
        $apunte = Apunte::findOrFail($id);
        if ($apunte->dni_usuario !== Auth::user()->dni) {
            abort(403);
        }

        $apunte->delete();
        return redirect()->route('alumno.apuntes.index')
                         ->with('success', 'Apunte eliminado.');
    }

    // 🔍 Mostrar apunte individual
    public function show($id)
    {
        $apunte = Apunte::findOrFail($id);

        if ($apunte->dni_usuario !== Auth::user()->dni) {
            abort(403);
        }

        return view('alumno.apuntes.show', compact('apunte'));
    }
}