<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LibroFisico;
use App\Models\LibroVirtual;
use App\Models\Reserva;
use App\Models\PrestamoFisico;
use App\Models\AccesoVirtual;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // === TARJETAS RESUMEN (CORREGIDO) ===
        $prestamosHoy = PrestamoFisico::whereDate('fecha_salida', today())->count();
        $lecturasHoy  = AccesoVirtual::whereDate('fecha_generacion', today())->count();
        $usuariosActivos = User::count();
        $totalCategorias = Categoria::count();

        // === GRÁFICO 1: PRÉSTAMOS POR MES (CORREGIDO) ===
        $prestamosMes = PrestamoFisico::selectRaw('MONTH(fecha_salida) as mes, COUNT(*) as total')
            ->whereNotNull('fecha_salida')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $prestamosMesLabels = $prestamosMes->pluck('mes')->map(function ($mes) {
            return Carbon::create()->month($mes)->locale('es')->monthName;
        });

        $prestamosMesData = $prestamosMes->pluck('total');

        // === GRÁFICO 2: CATEGORÍAS MÁS UTILIZADAS (CORREGIDO) ===
        $categorias = Categoria::select(
                'categorias.nombre_categoria',
                DB::raw('COUNT(prestamos_fisicos.id_prestamo) as total')
            )
            ->join('libros_fisicos', 'libros_fisicos.id_categoria', '=', 'categorias.id_categoria')
            ->join('prestamos_fisicos', 'prestamos_fisicos.id_libro_fisico', '=', 'libros_fisicos.id_libro_fisico')
            ->groupBy('categorias.nombre_categoria')
            ->orderByDesc('total')
            ->get();

        $categoriasLabels = $categorias->pluck('nombre_categoria');
        $categoriasData = $categorias->pluck('total');

        return view('admin.reportes.index', compact(
            'prestamosHoy',
            'lecturasHoy',
            'usuariosActivos',
            'totalCategorias',
            'prestamosMesLabels',
            'prestamosMesData',
            'categoriasLabels',
            'categoriasData'
        ));
    }


    // =======================
    // REPORTES INDIVIDUALES
    // =======================

    public function librosFisicosMasSolicitados()
    {
        $data = LibroFisico::select(
                'libros_fisicos.titulo',
                DB::raw('
                    (SELECT COUNT(*) FROM reservas 
                        WHERE reservas.id_libro_fisico = libros_fisicos.id_libro_fisico) +
                    (SELECT COUNT(*) FROM prestamos_fisicos 
                        WHERE prestamos_fisicos.id_libro_fisico = libros_fisicos.id_libro_fisico)
                    AS total_solicitudes
                ')
            )
            ->orderByDesc('total_solicitudes')
            ->limit(20)
            ->get();

        return view('admin.reportes.libros_fisicos_mas_solicitados', compact('data'));
    }

    public function librosVirtualesMasLeidos()
    {
        $data = LibroVirtual::select(
                'libros_virtuales.titulo',
                DB::raw('COUNT(accesos_virtuales.id_acceso) AS total_accesos')
            )
            ->leftJoin('accesos_virtuales', 'accesos_virtuales.id_libro_virtual', '=', 'libros_virtuales.id_libro_virtual')
            ->groupBy('libros_virtuales.titulo', 'libros_virtuales.id_libro_virtual')
            ->orderByDesc('total_accesos')
            ->limit(20)
            ->get();

        return view('admin.reportes.libros_virtuales_mas_leidos', compact('data'));
    }

    public function usuariosConMasPrestamos()
    {
        $data = PrestamoFisico::select(
                'dni_usuario',
                DB::raw('COUNT(*) AS total_prestamos')
            )
            ->groupBy('dni_usuario')
            ->orderByDesc('total_prestamos')
            ->limit(20)
            ->get();

        return view('admin.reportes.usuarios_mas_prestamos', compact('data'));
    }

    public function usuariosMasLecturaVirtual()
    {
        $data = AccesoVirtual::select(
                'dni_usuario',
                DB::raw('COUNT(*) AS total_accesos')
            )
            ->groupBy('dni_usuario')
            ->orderByDesc('total_accesos')
            ->limit(20)
            ->get();

        return view('admin.reportes.usuarios_lectura_virtual', compact('data'));
    }
}
