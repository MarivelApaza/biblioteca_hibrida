@extends('layouts.admin')

@section('title', 'Reportes')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4"><i class="fas fa-chart-pie"></i> Panel de Reportes</h1>

    {{-- TARJETAS RESUMEN --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <i class="fas fa-book fa-2x text-primary"></i>
                <h5 class="mt-2">Préstamos Hoy</h5>
                <h3 class="fw-bold">{{ $prestamosHoy }}</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                <h5 class="mt-2">Lecturas Virtuales Hoy</h5>
                <h3 class="fw-bold">{{ $lecturasHoy }}</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <i class="fas fa-users fa-2x text-success"></i>
                <h5 class="mt-2">Usuarios Activos</h5>
                <h3 class="fw-bold">{{ $usuariosActivos }}</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow text-center p-3">
                <i class="fas fa-layer-group fa-2x text-warning"></i>
                <h5 class="mt-2">Categorías Registradas</h5>
                <h3 class="fw-bold">{{ $totalCategorias }}</h3>
            </div>
        </div>

    </div>

    {{-- NUEVA SECCIÓN: PRÉSTAMOS POR MES (SIN GRÁFICAS) --}}
    <div class="card shadow mb-4 p-3">
        <h4 class="mb-3"><i class="fas fa-calendar"></i> Préstamos por Mes</h4>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Mes</th>
                    <th>Total de Préstamos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prestamosMesLabels as $i => $mes)
                    <tr>
                        <td>{{ $mes }}</td>
                        <td>{{ $prestamosMesData[$i] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- NUEVA SECCIÓN: TOP CATEGORÍAS --}}
    <div class="card shadow mb-4 p-3">
        <h4 class="mb-3"><i class="fas fa-layer-group"></i> Categorías Más Utilizadas</h4>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Categoría</th>
                    <th>Total de Préstamos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoriasLabels as $i => $cat)
                    <tr>
                        <td>{{ $cat }}</td>
                        <td>{{ $categoriasData[$i] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- OPCIONES DE REPORTES --}}
    <h3 class="mt-4 mb-3">Reportes Detallados</h3>

    <div class="row">

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.reportes.libros_fisicos_mas_solicitados') }}"
               class="card shadow p-3 text-center text-decoration-none text-dark">
                <i class="fas fa-book fa-2x"></i>
                <h5 class="mt-2">Libros Físicos Más Solicitados</h5>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.reportes.libros_virtuales_mas_leidos') }}"
               class="card shadow p-3 text-center text-decoration-none text-dark">
                <i class="fas fa-file-pdf fa-2x"></i>
                <h5 class="mt-2">Libros Virtuales Más Leídos</h5>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.reportes.usuarios_mas_prestamos') }}"
               class="card shadow p-3 text-center text-decoration-none text-dark">
                <i class="fas fa-users fa-2x"></i>
                <h5 class="mt-2">Usuarios con Más Préstamos</h5>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.reportes.usuarios_mas_lectura_virtual') }}"
               class="card shadow p-3 text-center text-decoration-none text-dark">
                <i class="fas fa-laptop fa-2x"></i>
                <h5 class="mt-2">Usuarios con Más Lectura Virtual</h5>
            </a>
        </div>

    </div>

</div>
@endsection

@push('styles')
<style>

/* ==========================================================
   🎨 TÍTULO GENERAL DEL MÓDULO
========================================================== */
h1.mb-4 {
    color: #043a4a !important;
    font-weight: 900 !important;
    background: linear-gradient(90deg, #7de3e0, #b3ecff, #e6dbff);
    padding: 0.6rem 1rem;
    border-radius: 0.8rem;
    display: inline-block;
    box-shadow: 0 6px 18px rgba(0,0,0,0.10);
}


/* ==========================================================
   🎨 TARJETAS RESUMEN — COLOR MÁS FUERTE
========================================================== */
.card.shadow.text-center {
    background: linear-gradient(135deg, #b3ecff, #7de3e0, #a8f2df) !important;
    border-radius: 1.3rem !important;
    border: none !important;
    box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
    transition: .28s ease-in-out !important;
}

.card.shadow.text-center:hover {
    transform: translateY(-7px);
    box-shadow: 0 16px 28px rgba(0,0,0,0.2) !important;
}

.card.shadow.text-center h5 {
    color: #033743 !important;
    font-weight: 700 !important;
}

.card.shadow.text-center h3 {
    color: #032d33 !important;
    font-weight: 900 !important;
}

/* Iconos con color pastel fuerte */
.card.shadow.text-center i {
    text-shadow: 0px 3px 6px rgba(0,0,0,0.15);
}


/* ==========================================================
   🎨 TABLA PASTEL MEJORADA
========================================================== */

.table thead {
    background: linear-gradient(90deg, #b3ecff, #7de3e0) !important;
    color: #043a4a !important;
    border-bottom: 3px solid #81dce0 !important;
    font-weight: bold;
}

.table tbody tr:nth-child(odd) {
    background: #f3fcff !important;
}

.table tbody tr:nth-child(even) {
    background: #ffffff !important;
}

.table tbody tr:hover {
    background: #dff8ff !important;
    transition: .2s ease;
}

/* Borde suave */
.table-bordered > :not(caption) > * > * {
    border-color: #b7e4ea !important;
}


/* ==========================================================
   🎨 CARDS DE REPORTES DETALLADOS (las 4 opciones)
========================================================== */

.card.p-3.text-center {
    background: linear-gradient(135deg, #ffffff, #e6faff, #ffe2cc) !important;
    border-radius: 1.3rem !important;
    border: 2px solid #bdefff !important;
    box-shadow: 0 8px 16px rgba(0,0,0,0.10);
    transition: .28s ease;
}

.card.p-3.text-center:hover {
    transform: translateY(-8px);
    background: linear-gradient(135deg, #dffaff, #ffeae0, #e6dbff) !important;
    border-color: #9aeafc !important;
    box-shadow: 0 16px 28px rgba(0,0,0,0.18);
}

.card.p-3.text-center i {
    color: #064663 !important;
}

.card.p-3.text-center h5 {
    color: #043a4a !important;
    font-weight: 700;
}



/* ==========================================================
   🎨 SECCIÓN: TITULOS SECUNDARIOS
========================================================== */
h4 {
    color: #064663 !important;
    font-weight: 800 !important;
    margin-bottom: 15px;
    border-left: 8px solid #7de3e0;
    padding-left: 12px;
}


/* ==========================================================
   🎨 CARD PRINCIPAL DE TABLAS Y SECCIONES
========================================================== */
.card.shadow.mb-4 {
    border-radius: 1.2rem !important;
    padding: 1rem !important;
    background: linear-gradient(135deg, #ffffff, #f3fcff) !important;
    border: 2px solid #c8f3ff !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
}

.card.shadow.mb-4:hover {
    box-shadow: 0 14px 24px rgba(0,0,0,0.15) !important;
}


/* ==========================================================
   🎨 Paginación pastel
========================================================== */
.pagination .page-link {
    background-color: #e6faff !important;
    border-color: #bdefff !important;
    color: #064663 !important;
}

.pagination .page-link:hover {
    background-color: #b3ecff !important;
}

.pagination .active .page-link {
    background-color: #7de3e0 !important;
    color: #ffffff !important;
    border-color: #55d3cc !important;
}

</style>
@endpush
