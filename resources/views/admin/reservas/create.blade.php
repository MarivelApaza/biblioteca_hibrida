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

