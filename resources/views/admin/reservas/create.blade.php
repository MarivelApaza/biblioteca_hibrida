@extends('layouts.admin')

@section('title', 'Reservar Libro')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4"><i class="fas fa-calendar-plus"></i> Reservar Libro</h1>

    {{-- 1) Seleccionar Alumno --}}
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <strong>1. Seleccionar Alumno</strong>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('admin.reservas.create') }}">
                <label for="alumno_input"><strong>Buscar alumno (DNI o nombre):</strong></label>
                <input list="alumnos_list" name="alumno" id="alumno_input" class="form-control"
                       placeholder="Escribe DNI o nombre..." autocomplete="off"
                       value="{{ old('alumno', request('alumno')) }}">

                <datalist id="alumnos_list">
                    @foreach($alumnos as $a)
                        <option data-dni="{{ $a->dni }}" 
                                value="{{ $a->dni }} - {{ $a->nombres }} {{ $a->apellidos }}">
                    @endforeach
                </datalist>

                <button type="submit" class="btn btn-outline-primary mt-2">Buscar alumno</button>
            </form>

            @if(request('alumno'))
                @php
                    $partes = explode(" - ", request('alumno'));
                    $dni_selected = $partes[0] ?? null;
                    $nombre_selected = $partes[1] ?? null;
                @endphp
                <div class="alert alert-success mt-2">
                    Alumno seleccionado: <strong>{{ $nombre_selected }}</strong> (DNI: {{ $dni_selected }})
                </div>
            @endif
        </div>
    </div>

    {{-- 2) Buscar libros físicos --}}
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-success text-white">
            <strong>2. Buscar Libro</strong>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('admin.reservas.create') }}">
                <input type="hidden" name="alumno" value="{{ request('alumno') }}">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label><strong>Categoría:</strong></label>
                        <select name="categoria" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}"
                                    {{ request('categoria') == $cat->id_categoria ? 'selected' : '' }}>
                                    {{ $cat->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label><strong>Buscar por título:</strong></label>
                        <input type="text" name="titulo" class="form-control"
                               placeholder="Escribe título..."
                               value="{{ request('titulo') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-success">Buscar libros</button>
            </form>

            {{-- Tabla de libros filtrados --}}
            @if(isset($libros) && count($libros))
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Ubicación</th>
                            <th>Stock</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($libros as $libro)
                            <tr>
                                <td>{{ $libro->titulo }}</td>
                                <td>{{ $libro->categoria->nombre_categoria }}</td>
                                <td>{{ $libro->ubicacion_pasillo }}</td>
                                <td>{{ $libro->stock_disponible }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.reservas.store') }}">
                                        @csrf
                                        <input type="hidden" name="dni_usuario" value="{{ $dni_selected ?? '' }}">
                                        <input type="hidden" name="id_libro_fisico" value="{{ $libro->id_libro_fisico }}">
                                        <input type="date" name="fecha_limite_recojo" required>
                                        <button type="submit" class="btn btn-success btn-sm">Reservar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif(request()->hasAny(['categoria','titulo']))
                <div class="alert alert-warning mt-3">No se encontraron libros.</div>
            @endif

        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
/* ==========================================================
   🌈 PALETA PASTEL INTENSA
========================================================== */
:root {
    --grad-azul: linear-gradient(135deg, #CDEFFC, #99DFFF, #7FCBF7);
    --grad-turquesa: linear-gradient(135deg, #C7FFF4, #8FF7E3, #6EECD4);
    --grad-verde: linear-gradient(135deg, #D6FFE5, #B3FFD1, #89F8BB);
    --grad-rosado: linear-gradient(135deg, #FFE1EC, #FFBDD3, #FF9ABD);
    --grad-amarillo: linear-gradient(135deg, #FFF4C9, #FFE7A3, #FFD97C);
    --texto-oscuro: #033b47;
}

/* ==========================================================
   🟦 TÍTULO PRINCIPAL CON DEGRADADO
========================================================== */
h1 {
    background: linear-gradient(90deg, #05445E, #5BE6D2);
    -webkit-background-clip: text;
    color: transparent !important;
    font-weight: 900 !important;
}

/* ==========================================================
   🎀 TARJETAS PRINCIPALES CON MÁS COLOR
========================================================== */
.card {
    border-radius: 2rem !important;
    background: rgba(255, 255, 255, 0.55) !important;
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.8);
    box-shadow: 0 12px 35px rgba(0,0,0,0.12);
    transition: 0.35s ease-in-out;
}

.card:hover {
    transform: translateY(-6px);
}

/* Header Azul Pastel + Degradado */
.card-header.bg-primary {
    background: var(--grad-azul) !important;
    color: var(--texto-oscuro) !important;
    border-radius: 2rem 2rem 0 0 !important;
    padding: 1.2rem 1.8rem !important;
    font-size: 1.15rem;
    font-weight: 800;
}

/* Header Verde Pastel + Degradado */
.card-header.bg-success {
    background: var(--grad-verde) !important;
    color: var(--texto-oscuro) !important;
    border-radius: 2rem 2rem 0 0 !important;
    padding: 1.2rem 1.8rem !important;
    font-size: 1.15rem;
    font-weight: 800;
}

/* ==========================================================
   ✨ INPUTS CON DEGRADADO SUAVE Y GLOW
========================================================== */
.form-control,
.form-select {
    border-radius: 1rem !important;
    border: 2px solid transparent !important;
    background: linear-gradient(white, white) padding-box,
                linear-gradient(90deg, #8edbff, #6cf4de) border-box !important;
    color: #033b47;
    box-shadow: 0 5px 12px rgba(0,150,150,0.1);
}

.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 12px rgba(0, 180, 200, 0.6) !important;
    transform: scale(1.02);
}

/* ==========================================================
   💎 BOTONES DEGRADADOS BRILLANTES
========================================================== */
.btn-outline-primary {
    border-radius: 1rem;
    background: linear-gradient(135deg, #D7EEFF, #B4E2FF);
    border: none !important;
    color: #04384a !important;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #A8DBFF, #80CAFF) !important;
}

/* Botón buscar libros */
.btn-outline-success {
    border-radius: 1rem;
    background: linear-gradient(135deg, #C7FFF3, #98F5DD);
    border: none !important;
    color: #0e5f49 !important;
}

.btn-outline-success:hover {
    background: linear-gradient(135deg, #9BFFE5, #6AF2CE) !important;
}

/* Botón reservar */
.btn-success {
    border-radius: 1rem;
    background: linear-gradient(135deg, #05445E, #185874ff, #19607eff) !important;
    border: none !important;
    font-weight: 700 !important;
}

.btn-success:hover {
    background: linear-gradient(135deg, #6a76acff, #8f99d3ff) !important;
    transform: scale(1.04);
}

/* ==========================================================
   📚 TABLA SUPER PASTEL PREMIUM
========================================================== */
.table {
    border-radius: 1.5rem !important;
    overflow: hidden;
    margin-top: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* Encabezado con degradado */
.table thead {
    background: var(--grad-turquesa) !important;
    color: #033b47 !important;
    font-weight: 800;
    letter-spacing: .03em;
}

/* Filas */
.table tbody tr {
    transition: 0.2s ease;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

/* Hover brillante */
.table tbody tr:hover {
    background: rgba(150, 240, 255, 0.45) !important;
}

/* Celdas */
.table td, .table th {
    padding: 1rem !important;
    color: #033b47 !important;
}

/* ==========================================================
   🔔 ALERTAS PASTEL MÁS COLORIDAS
========================================================== */
.alert-success {
    background: var(--grad-turquesa) !important;
    border: none !important;
    border-radius: 1.2rem !important;
    color: #07493d !important;
    box-shadow: 0 6px 18px rgba(0,255,200,0.2);
}

.alert-warning {
    background: var(--grad-amarillo) !important;
    border: none !important;
    border-radius: 1.2rem !important;
    color: #715600 !important;
}

</style>
@endpush