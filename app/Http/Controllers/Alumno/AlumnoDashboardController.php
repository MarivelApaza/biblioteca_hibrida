<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;
use App\Models\PrestamoFisico;
use App\Models\AccesoVirtual;
use App\Models\LibroFisico;
use App\Models\LibroVirtual;

class AlumnoDashboardController extends Controller
{
    public function index()
    {
        $dni = Auth::user()->dni;

        // Contar reservas del alumno
        $reservasActivas = Reserva::where('dni_usuario', $dni)
            ->where('estado', 'ACTIVA')
            ->count();

        // Contar préstamos del alumno
        $prestamosActivos = PrestamoFisico::where('dni_usuario', $dni)
            ->where('estado', 'PRESTADO')
            ->count();

        // Contar accesos virtuales
        $accesosVirtuales = AccesoVirtual::where('dni_usuario', $dni)->count();

        // Últimos libros añadidos
        $ultimosFisicos = LibroFisico::orderBy('created_at', 'DESC')->limit(5)->get();
        $ultimosVirtuales = LibroVirtual::orderBy('created_at', 'DESC')->limit(5)->get();

        return view('alumno.dashboard', compact(
            'reservasActivas',
            'prestamosActivos',
            'accesosVirtuales',
            'ultimosFisicos',
            'ultimosVirtuales'
        ));
    }
}
