@extends('layouts.admin')

@section('title', 'Libros Virtuales Más Leídos')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">📕 Libros Virtuales Más Leídos</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Total Accesos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->titulo }}</td>
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
   🌟 TABLA CELESTE PREMIUM — COMPATIBLE CON .table-bordered
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

/* Quitamos los bordes feos de .table-bordered */
.table-bordered, 
.table-bordered > :not(caption) > * > * {
    border: none !important;
}

/* ==========================================================
   🔥 ENCABEZADO CELESTE FORZADO — Ahora sí se aplica
========================================================== */

table.table thead tr th,
.table-bordered thead th {
    background: linear-gradient(135deg, #CDEFFC, #A6DDF0, #9AD2E8) !important;
    color: #033b47 !important;
    font-weight: 900 !important;
    padding: 1.1rem !important;
    letter-spacing: .03em;
    border: none !important;
}

/* Cancelar fondo blanco que pone Bootstrap */
.table thead th {
    background-color: transparent !important;
}

/* ==========================================================
   🌟 FILAS DEL CUERPO — Celeste limpio
========================================================== */

.table tbody tr {
    background: #ffffff !important;
    color: #033b47 !important;
    transition: .25s ease;
}

.table tbody tr:hover {
    background: rgba(205, 239, 252, 0.50) !important;
}

/* Celdas */
.table td, .table th {
    padding: 1rem !important;
    color: #033b47 !important;
    border-bottom: 1px solid rgba(0,0,0,0.06) !important;
}

/* Última fila sin borde */
.table tbody tr:last-child td {
    border-bottom: none !important;
}

/* ==========================================================
   🌟 BORDES SUAVES SOLO EN LA TABLA, NO EN CELDAS
========================================================== */

.table-bordered {
    border-radius: 1.4rem !important;
    border: 2px solid #CDEFFC !important;
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