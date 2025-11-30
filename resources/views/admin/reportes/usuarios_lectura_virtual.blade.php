@extends('layouts.admin')

@section('title', 'Usuarios con Más Lectura Virtual')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">💻 Usuarios con mayor lectura virtual</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Total Accesos Virtuales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->dni_usuario }}</td>
                <td>{{ $row->total_accesos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('styles')
<style>
    /* ==========================================================
   🌟 TABLA CELESTE PREMIUM — TOTALMENTE COMPATIBLE CON .table-bordered
========================================================== */

/* Contenedor de tabla */
.table {
    border-radius: 1.4rem !important;
    overflow: hidden !important;
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(7px);
    box-shadow: 0 10px 25px rgba(0, 120, 150, 0.18);
    border: none !important;
}

/* Quitamos los bordes duros de .table-bordered */
.table-bordered,
.table-bordered > :not(caption) > * > * {
    border: none !important;
}

/* ==========================================================
   🔥 ENCABEZADO CELESTE FORZADO
========================================================== */
table.table thead tr th,
.table-bordered thead th {
    background: linear-gradient(135deg, #CDEFFC, #A6DDF0, #9AD2E8) !important;
    color: #033b47 !important;
    font-weight: 900 !important;
    padding: 1rem !important;
    font-size: 1.05rem;
    border: none !important;
    letter-spacing: .03em;
}

/* Anula cualquier fondo gris de Bootstrap */
.table thead th {
    background-color: transparent !important;
}

/* ==========================================================
   🌟 FILAS — CELESTE PROFESIONAL
========================================================== */

.table tbody tr {
    background: #ffffff !important;
    color: #033b47 !important;
    transition: 0.25s ease;
}

.table tbody tr:hover {
    background: rgba(205, 239, 252, 0.55) !important;
}

/* Celdas */
.table td, 
.table th {
    padding: 1rem !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
    font-size: 1rem;
    color: #033b47 !important;
}

/* Elimina borde final */
.table tbody tr:last-child td {
    border-bottom: none !important;
}

/* ==========================================================
   🌟 BORDES EXTERIORES CELESTES (bonito)
========================================================== */
.table-bordered {
    border: 2px solid #CDEFFC !important;
    border-radius: 1.4rem !important;
}

/* ==========================================================
   🌟 FILAS RAYADAS CELESTES
========================================================== */
.table-striped > tbody > tr:nth-of-type(odd) {
    background: rgba(245, 250, 255, 0.9) !important;
}

.table-striped > tbody > tr:nth-of-type(odd):hover {
    background: rgba(205,239,252,0.55) !important;
}

/* ==========================================================
   🌟 TÍTULO PREMIUM CELESTE
========================================================== */
h2.mb-4 {
    font-weight: 900 !important;
    color: #033b47 !important;
    letter-spacing: .7px;
    text-shadow: 0 2px 5px rgba(0,80,110,0.25);
    display: flex;
    align-items: center;
    gap: .5rem;
}

</style>
@endpush