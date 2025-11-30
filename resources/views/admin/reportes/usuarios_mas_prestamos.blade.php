@extends('layouts.admin')

@section('title', 'Usuarios con Más Préstamos')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">👨‍🎓 Usuarios con más préstamos</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Total Préstamos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->dni_usuario }}</td>
                <td>{{ $row->total_prestamos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('styles')
<style>
    /* ==========================================================
   🌟 TABLA CELESTE PREMIUM — 100% CELESTE
========================================================== */

/* Fondo general de la tabla */
.table {
    border-radius: 1.4rem !important;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.65) !important;
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 25px rgba(0, 120, 150, 0.15);
    border: none !important;
}

/* ==========================================================
   🔥 ENCABEZADO — CELESTE FORZADO
========================================================== */

/* Este selector vence a AdminLTE */
table.table thead tr th {
    background: linear-gradient(135deg, #CDEFFC, #A6DDF0, #9AD2E8) !important;
    color: #033b47 !important;
    font-weight: 900 !important;
    padding: 1rem !important;
    border-bottom: none !important;
    letter-spacing: .03em;
}

/* Cancelamos fondo blanco de Bootstrap / AdminLTE */
.table thead th {
    background-color: transparent !important;
}

/* ==========================================================
   🌟 FILAS DEL CUERPO
========================================================== */

.table tbody tr {
    background: #ffffff !important;
    color: #033b47 !important;
    transition: .25s ease;
}

.table tbody tr:hover {
    background: rgba(205, 239, 252, 0.55) !important; /* Celeste hover */
}

/* Celdas del cuerpo */
.table td, .table th {
    padding: 1rem !important;
    font-size: 1rem;
    color: #033b47 !important;
    border-bottom: 1px solid rgba(0,0,0,0.06) !important;
}

/* Última fila sin borde duro */
.table tbody tr:last-child td {
    border-bottom: none !important;
}

/* ==========================================================
   🌟 RAYADO CELESTE SUAVE
========================================================== */

.table-striped > tbody > tr:nth-of-type(odd) {
    background: rgba(245, 250, 255, 0.9) !important;
}

.table-striped > tbody > tr:nth-of-type(odd):hover {
    background: rgba(205,239,252,0.55) !important;
}

/* ==========================================================
   🌟 TITULO (opcional para combinar)
========================================================== */
h2.mb-4 {
    font-weight: 900 !important;
    color: #033b47 !important;
    letter-spacing: .7px;
    text-shadow: 0 2px 5px rgba(0,80,110,0.25);
}

</style>
@endpush