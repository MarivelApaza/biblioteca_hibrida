<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        $usuarios = User::orderBy('nombres')->paginate(15); // Paginación opcional
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario de creación (opcional, ya que alumnos se registran).
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name'); // ['ALUMNO' => 'ALUMNO', 'ADMINISTRADOR' => 'ADMINISTRADOR']
        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Guardar un usuario nuevo (opcional).
     */
   public function store(Request $request)
{
    $request->validate([
        'dni' => 'required|string|unique:users,dni',
        'nombres' => 'required|string',
        'apellidos' => 'required|string',
        'password' => 'required|string|min:6',
        'rol' => 'required|in:ALUMNO,ADMINISTRADOR',
        'estado' => 'required|in:ACTIVO,SANCIONADO',
    ]);

    $user = User::create([
        'dni' => $request->dni,
        'nombres' => $request->nombres,
        'apellidos' => $request->apellidos,
        'password' => Hash::make($request->password),
        'semestre' => $request->semestre,
        'turno' => $request->turno,
        'telefono' => $request->telefono,
        'rol' => $request->rol,
        'estado' => $request->estado,
    ]);

    // ASIGNAR ROL DE SPATIE (si lo usas)
    $user->syncRoles($request->rol);

    return redirect()->route('admin.usuarios.index')
                     ->with('success', 'Usuario creado correctamente.');
}


    /**
     * Mostrar un usuario específico.
     */
    public function show($dni)
    {
        $usuario = User::findOrFail($dni);
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($dni)
    {
        $usuario = User::findOrFail($dni);
        $roles = Role::pluck('name', 'name');
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, $dni)
    {
        $usuario = User::findOrFail($dni);

        $request->validate([
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
            'rol' => 'required|in:ALUMNO,ADMINISTRADOR',
            'estado' => 'required|in:ACTIVO,SANCIONADO',
        ]);

        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->semestre = $request->semestre ?? $usuario->semestre;
        $usuario->turno = $request->turno ?? $usuario->turno;
        $usuario->direccion = $request->direccion ?? $usuario->direccion;
        $usuario->telefono = $request->telefono ?? $usuario->telefono;
        $usuario->rol = $request->rol;
        $usuario->estado = $request->estado;

        if ($request->password) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();
        $usuario->syncRoles($request->rol);

        return redirect()->route('admin.usuarios.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy($dni)
    {
        $usuario = User::findOrFail($dni);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
