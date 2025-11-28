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
