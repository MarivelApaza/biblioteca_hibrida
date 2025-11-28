<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\LibroFisicoController;
use App\Http\Controllers\Admin\LibroVirtualController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\PrestamoFisicoController;

// Alumno Controllers
use App\Http\Controllers\Alumno\AlumnoDashboardController;
use App\Http\Controllers\Alumno\CatalogoController;
use App\Http\Controllers\Alumno\ReservaController as AlumnoReservaController;
use App\Http\Controllers\Alumno\AccesoVirtualController;
use App\Http\Controllers\Alumno\FavoritoController;
use App\Http\Controllers\Alumno\ApunteController;

/*=======================================================
| REDIRECCIÓN RAÍZ
=========================================================*/
Route::get('/', fn() => redirect()->route('login'))->name('home');

/*=======================================================
| REDIRECCIÓN SEGÚN ROL
=========================================================*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) return redirect()->route('login');

    return match ($user->rol) {
        'ADMINISTRADOR' => redirect()->route('admin.dashboard'),
        'ALUMNO'        => redirect()->route('alumno.dashboard'),
        default         => tap(Auth::logout(), fn() => redirect()->route('login'))
    };
})->name('dashboard');

/*=======================================================
| RUTAS PROTEGIDAS POR AUTH
=========================================================*/
Route::middleware('auth')->group(function () {

    /* PERFIL */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*=======================================================
    | ADMIN
    =========================================================*/
    Route::prefix('admin')->name('admin.')->middleware('role:ADMINISTRADOR')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', function () {
            Auth::logout();
            return redirect()->route('login');
        })->name('logout');

        Route::resources([
            'usuarios'         => UsuarioController::class,
            'categorias'       => CategoriaController::class,
            'libros_fisicos'   => LibroFisicoController::class,
            'libros_virtuales' => LibroVirtualController::class,
        ]);

        // Reservas
        Route::resource('reservas', AdminReservaController::class);
        Route::patch('reservas/{id}/completar', [AdminReservaController::class, 'marcarCompletada'])->name('reservas.completar');
        Route::patch('reservas/{id}/expirar', [AdminReservaController::class, 'expirar'])->name('reservas.expirar');
        Route::patch('reservas/{id}/convertir-prestamo', [AdminReservaController::class, 'convertirAPrestamo'])->name('reservas.convertirPrestamo');

        // Préstamos físicos
        Route::resource('prestamos_fisicos', PrestamoFisicoController::class);
        Route::get('prestamos_fisicos/{id}/devolver', [PrestamoFisicoController::class, 'devolverForm'])->name('prestamos_fisicos.devolverForm');
        Route::patch('prestamos_fisicos/{id}/devolver', [PrestamoFisicoController::class, 'devolver'])->name('prestamos_fisicos.devolver');
    });

    /*=======================================================
    | REPORTES ADMIN
    =========================================================*/
    Route::prefix('admin/reportes')->name('admin.reportes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Reportes\ReporteController::class, 'index'])->name('index');
        Route::get('/libros-fisicos-mas-solicitados',
            [\App\Http\Controllers\Reportes\ReporteController::class, 'librosFisicosMasSolicitados'])->name('libros_fisicos_mas_solicitados');
        Route::get('/libros-virtuales-mas-leidos',
            [\App\Http\Controllers\Reportes\ReporteController::class, 'librosVirtualesMasLeidos'])->name('libros_virtuales_mas_leidos');
        Route::get('/usuarios-mas-prestamos',
            [\App\Http\Controllers\Reportes\ReporteController::class, 'usuariosConMasPrestamos'])->name('usuarios_mas_prestamos');
        Route::get('/usuarios-mas-lectura-virtual',
            [\App\Http\Controllers\Reportes\ReporteController::class, 'usuariosMasLecturaVirtual'])->name('usuarios_mas_lectura_virtual');
    });

    /*=======================================================
    | ALUMNO
    =========================================================*/
    Route::prefix('alumno')->name('alumno.')->middleware('role:ALUMNO')->group(function () {

        Route::get('/dashboard', [AlumnoDashboardController::class, 'index'])->name('dashboard');

        /* CATÁLOGO */
        Route::get('catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
        Route::get('catalogo/virtual/{id}', [CatalogoController::class, 'showVirtual'])->name('catalogo.showVirtual');
        Route::get('catalogo/fisico/{id}', [CatalogoController::class, 'showFisico'])->name('catalogo.showFisico');

        /* RESERVAS */
        Route::get('reservas/create/{id_libro_fisico}', [AlumnoReservaController::class, 'create'])->name('reservas.create');
        Route::post('reservas/store', [AlumnoReservaController::class, 'store'])->name('reservas.store');
        Route::get('reservas', [AlumnoReservaController::class, 'index'])->name('reservas.index');
        Route::delete('reservas/{id_reserva}', [AlumnoReservaController::class, 'destroy'])->name('reservas.destroy');

        /* ACCESOS VIRTUALES */
        Route::get('accesos/pdf/{token}', [AccesoVirtualController::class, 'accederPDF'])->name('accesos.pdf');
        Route::get('accesos/create/{id_libro}', [AccesoVirtualController::class, 'create'])->name('accesos.create');
        Route::post('accesos', [AccesoVirtualController::class, 'store'])->name('accesos.store');
        Route::resource('accesos', AccesoVirtualController::class)->only(['index', 'show']);
        Route::delete('accesos/{id_acceso}', [AccesoVirtualController::class, 'destroy'])->name('accesos.destroy');

        /* FAVORITOS */
        Route::get('favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
        Route::post('favoritos', [FavoritoController::class, 'store'])->name('favoritos.store');
        Route::delete('favoritos/{id}', [FavoritoController::class, 'destroy'])->name('favoritos.destroy');

        /* APUNTES */
        Route::prefix('apuntes')->name('apuntes.')->group(function () {
            Route::get('/', [ApunteController::class, 'index'])->name('index');
            Route::get('/seleccionar-libro', [ApunteController::class, 'seleccionarLibro'])->name('seleccionar');
            Route::get('/create/{id_libro}', [ApunteController::class, 'create'])->name('create');
            Route::post('/', [ApunteController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ApunteController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ApunteController::class, 'update'])->name('update');
            Route::get('/{id}/ver', [ApunteController::class, 'show'])->name('show');
            Route::delete('/{id}', [ApunteController::class, 'destroy'])->name('destroy');
        });

        /* LOGOUT */
        Route::post('/logout', function () {
            Auth::logout();
            return redirect()->route('login');
        })->name('logout');
    });
});

require __DIR__ . '/auth.php';
