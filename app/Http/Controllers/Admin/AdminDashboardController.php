<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categoria;
use App\Models\LibroFisico;
use App\Models\LibroVirtual;
use App\Models\Reserva;
use App\Models\PrestamoFisico;

class AdminDashboardController extends Controller
{
    /**
     * Mostrar el dashboard del administrador
     */
    public function index()
    {
        // Estadísticas de usuarios
        $totalUsuarios = User::count();
        $totalAlumnos = User::where('rol', 'ALUMNO')->count();
        $totalAdmins = User::where('rol', 'ADMINISTRADOR')->count();

        // Estadísticas de categorías
        $totalCategorias = Categoria::count();

        // Estadísticas de libros
        $totalLibrosFisicos = LibroFisico::count();
        $librosFisicosDisponibles = LibroFisico::sum('stock_disponible');

        $totalLibrosVirtuales = LibroVirtual::count();

        // Estadísticas de transacciones
        $totalReservasActivas = Reserva::where('estado', 'ACTIVA')->count();
        $totalPrestamosPendientes = PrestamoFisico::where('estado', 'PENDIENTE')->count();
        $totalPrestamosMora = PrestamoFisico::where('estado', 'MORA')->count();

        // Últimos préstamos (aunque no haya registros, devuelve colección vacía)
        $ultimosPrestamos = PrestamoFisico::with(['usuario', 'libroFisico'])
            ->orderBy('fecha_salida', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalAlumnos',
            'totalAdmins',
            'totalCategorias',
            'totalLibrosFisicos',
            'librosFisicosDisponibles',
            'totalLibrosVirtuales',
            'totalReservasActivas',
            'totalPrestamosPendientes',
            'totalPrestamosMora',
            'ultimosPrestamos' // <-- ahora sí se pasa a la vista
        ));
    }
}
