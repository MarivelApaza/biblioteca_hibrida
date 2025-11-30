@extends('layouts.admin')

@section('title', 'Registrar Préstamo Físico')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book-reader"></i> Registrar Préstamo Físico</h1>

    {{-- 1) Seleccionar Alumno --}}
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <strong>1. Seleccionar Alumno</strong>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.prestamos_fisicos.create') }}">
                <div class="mb-3">
                    <label for="alumno_input"><strong>Buscar alumno (DNI o nombre):</strong></label>
                    <input list="alumnos_list" name="alumno" id="alumno_input" class="form-control"
                           placeholder="Escribe DNI o nombre..." autocomplete="off"
                           value="{{ old('alumno', request('alumno')) }}">
                    <datalist id="alumnos_list">
                        @foreach($usuarios as $u)
                            <option data-dni="{{ $u->dni }}" 
                                    value="{{ $u->dni }} - {{ $u->nombres }} {{ $u->apellidos }}">
                        @endforeach
                    </datalist>
                </div>

                <button type="submit" class="btn btn-outline-primary mt-2"><i class="fas fa-user-check"></i> Seleccionar Alumno</button>
            </form>

            @if(isset($dni_selected))
                <div class="alert alert-success mt-3 shadow-sm">
                    <i class="fas fa-user"></i> Alumno seleccionado: <strong>{{ $nombre_selected }}</strong> (DNI: {{ $dni_selected }})
                </div>
            @endif
        </div>
    </div>

    {{-- 2) Seleccionar Libro --}}
    @if(isset($dni_selected))
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-success text-white">
            <strong>2. Seleccionar Libro</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.prestamos_fisicos.store') }}">
                @csrf
                <input type="hidden" name="dni_usuario" value="{{ $dni_selected }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_libro_fisico"><strong>Libro:</strong></label>
                        <input type="text" id="libro_search" class="form-control mb-2" placeholder="Buscar libro por título o autor...">

                        <select name="id_libro_fisico" id="id_libro_fisico" class="form-select" required size="10">
                            @foreach($libros as $libro)
                                <option value="{{ $libro->id_libro_fisico }}"
                                        data-ubicacion="{{ $libro->ubicacion_pasillo }}"
                                        data-titulo="{{ $libro->titulo }}"
                                        data-autor="{{ $libro->autor }}">
                                    {{ $libro->titulo }} - {{ $libro->autor }} (Stock: {{ $libro->stock_disponible }})
                                </option>
                            @endforeach
                        </select>

                        {{-- Mensaje de información del libro --}}
                        <div id="info_libro" class="mt-3 p-3 border rounded shadow-sm bg-light text-dark" style="min-height: 60px;">
                            Selecciona un libro para ver la información
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="fecha_devolucion_programada"><strong>Fecha de devolución programada:</strong></label>
                        <input type="date" name="fecha_devolucion_programada" id="fecha_devolucion_programada" 
                               class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-2">
                    <i class="fas fa-plus"></i> Registrar Préstamo
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const libroSelect = document.getElementById('id_libro_fisico');
    const infoLibro = document.getElementById('info_libro');
    const libroSearch = document.getElementById('libro_search');

    // Mostrar información completa al seleccionar libro
    libroSelect.addEventListener('change', function() {
        const selectedOption = libroSelect.selectedOptions[0];
        if (selectedOption) {
            const titulo = selectedOption.dataset.titulo || '';
            const autor = selectedOption.dataset.autor || '';
            const ubicacion = selectedOption.dataset.ubicacion || 'No disponible';
            const codigo = selectedOption.value;

            // Mostrar con HTML y estilo visual
            infoLibro.innerHTML = `
                <h5 class="mb-1"><i class="fas fa-book"></i> ${titulo}</h5>
                <p class="mb-1"><strong>Autor:</strong> ${autor}</p>
                <p class="mb-1"><strong>Ubicación:</strong> ${ubicacion}</p>
                <p class="mb-0"><strong>Código:</strong> ${codigo}</p>
            `;
        }
    });

    // Filtrado de libros por título o autor
    libroSearch.addEventListener('input', function() {
        const filter = libroSearch.value.toLowerCase();
        for (const option of libroSelect.options) {
            const titulo = option.dataset.titulo?.toLowerCase() || '';
            const autor = option.dataset.autor?.toLowerCase() || '';
            option.style.display = (titulo.includes(filter) || autor.includes(filter)) ? '' : 'none';
        }
    });
});
</script>
@endsection

@push('styles')
<style>
    /* ==========================================================
   🌟 TÍTULO PRINCIPAL (Azul oscuro + brillo turquesa)
========================================================== */
h1.mb-4 {
    font-weight: 900 !important;
    color: #033b47 !important;
    font-size: 2.1rem;
    letter-spacing: .8px;
    text-shadow: 0 3px 6px rgba(0, 80, 110, 0.22);
}

h1.mb-4 i {
    color: #05668d !important;
}

/* ==========================================================
   🌟 TARJETAS GLASS PREMIUM (Celeste/Turquesa)
========================================================== */
.card {
    border-radius: 1.9rem !important;
    background: rgba(255, 255, 255, 0.55) !important;
    backdrop-filter: blur(13px);
    border: 2px solid rgba(255,255,255,0.65);
    box-shadow:
        0 12px 32px rgba(0, 120, 150, 0.12),
        inset 0 0 18px rgba(255,255,255,0.4);
    transition: .28s;
    position: relative;
    overflow: hidden;
}

/* Cinta lateral (TURQUESA) */
.card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 9px;
    height: 100%;
    border-radius: 10px 0 0 10px;
    background: linear-gradient(180deg, #7fdce8, #A8F2E6);
    box-shadow: 0 0 18px rgba(120,220,230,0.55);
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 
        0 22px 42px rgba(0, 110, 140, 0.22),
        inset 0 0 22px rgba(255,255,255,0.5);
}

/* ==========================================================
   🌟 HEADERS CELeste / TURQUESA
========================================================== */
.card-header {
    font-weight: 900 !important;
    font-size: 1.12rem;
    border-radius: 1.9rem 1.9rem 0 0 !important;
    letter-spacing: .5px;
    padding: 1.15rem 1.6rem;
    color: #033b47 !important;
}

.card-header::after {
    content: "";
    position: absolute;
    bottom: 6px;
    left: 15px;
    width: 60px;
    height: 3px;
    background: rgba(255,255,255,0.7);
    border-radius: 3px;
}

/* CELEste pastel */
.card-header.bg-primary {
    background: linear-gradient(135deg, #CDEFFC, #A6DCF0, #7EC7E3) !important;
}

/* TURQUESA pastel real */
.card-header.bg-success {
    background: linear-gradient(135deg, #a1cec6ff, #a5cfc9ff, #a3dbd4ff) !important;
}

/* Azul petróleo */
.card-header.bg-dark {
    background: linear-gradient(135deg, #A4C9D9, #6FA3B5, #467687) !important;
}

/* ==========================================================
   🌟 INPUTS Y SELECTS (CELeste / TURQUESA)
========================================================== */
.form-control,
.form-select {
    border-radius: 1rem !important;
    border: 1px solid #9dddf0 !important;
    background: #f3fcff !important;
    padding: .75rem 1rem !important;
    font-size: .97rem;
    color: #033b47 !important;
    transition: .2s;
}

.form-control:focus,
.form-select:focus {
    border-color: #66cde5 !important;
    box-shadow: 0 0 0 .22rem rgba(100,200,230,.28) !important;
    background: #ffffff !important;
}

/* ==========================================================
   🌟 SELECT GRANDE DE LIBROS
========================================================== */
#id_libro_fisico {
    height: 330px;
    border-radius: 1rem;
}

#id_libro_fisico option {
    padding: .65rem;
    border-bottom: 1px solid #d5f4ff;
    color: #033b47 !important;
}

#id_libro_fisico option:hover {
    background: #dffaff !important;
}

/* ==========================================================
   🌟 INFO DEL LIBRO SELECCIONADO (CELESTE pastel)
========================================================== */
#info_libro {
    border-radius: 1.2rem !important;
    background: linear-gradient(135deg, #E9FAFF, #D8F7FF) !important;
    border: 1px solid #bdeaf7 !important;
    color: #033b47 !important;
}

#info_libro h5 {
    font-weight: 900 !important;
}

/* ==========================================================
   🌟 ALERTA TURQUESA (sin verde)
========================================================== */
.alert-success {
    background: linear-gradient(135deg, #CDEFFC, #A8F2E6) !important;
    border: none !important;
    border-radius: 1rem !important;
    color: #033b47 !important;
    box-shadow: 0 4px 12px rgba(0,150,170,0.15);
}

/* ==========================================================
   🌟 BOTONES CELESTE / TURQUESA
========================================================== */

/* Botón buscar alumno */
.btn-outline-primary {
    border-radius: 1rem;
    border: 2px solid #7ccbed !important;
    color: #05668d !important;
    font-weight: 700;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #CDEFFC, #A6E7F6) !important;
    color: #033b47 !important;
}

/* Botón Registrar préstamo */
.btn-success {
    border-radius: 1rem !important;
    background: linear-gradient(135deg, #A8F2E6, #7ADFD0, #63D3C5) !important;
    border: none !important;
    font-weight: 800 !important;
    color: #033b47 !important;
    box-shadow: 0 6px 18px rgba(0,180,190,0.25);
    padding: .75rem 1.6rem !important;
}

.btn-success:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #8FE9DD, #66D6C7) !important;
}

</style>
@endpush