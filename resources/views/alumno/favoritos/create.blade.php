@extends('layouts.alumno')

@section('title', 'Agregar a Favoritos')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-heart"></i> Agregar a Favoritos</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('alumno.favoritos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tipo_recurso" class="form-label">Tipo de recurso</label>
                    <select name="tipo_recurso" id="tipo_recurso" class="form-select" required>
                        <option value="">Seleccionar...</option>
                        <option value="FISICO">Libro Físico</option>
                        <option value="VIRTUAL">Libro Virtual</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_referencia" class="form-label">Libro</label>
                    <select name="id_referencia" id="id_referencia" class="form-select" required>
                        <option value="">Seleccionar...</option>
                        <optgroup label="Libros Físicos">
                            @foreach($librosFisicos as $libro)
                                <option value="{{ $libro->id_libro_fisico }}">{{ $libro->titulo }} - {{ $libro->autor }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Libros Virtuales">
                            @foreach($librosVirtuales as $libro)
                                <option value="{{ $libro->id_libro_virtual }}">{{ $libro->titulo }} - {{ $libro->autor }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
        </div>
    </div>
</div>
@endsection
