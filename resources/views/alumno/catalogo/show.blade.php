@extends('layouts.alumno')

@section('title', 'Detalle del Libro')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book-open"></i> {{ $libro->titulo }}</h1>

    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $libro->imagen_portada) }}" class="img-fluid" alt="Portada">
        </div>
        <div class="col-md-8">
            <p><strong>Autor:</strong> {{ $libro->autor }}</p>
            <p><strong>Categoría:</strong> {{ $libro->categoria->nombre ?? '-' }}</p>
            <p><strong>Resumen:</strong> {{ $libro->resumen_sinopsis ?? 'No disponible' }}</p>
            <p><strong>Palabras clave:</strong> {{ $libro->palabras_clave ?? '-' }}</p>
            @if($libro->stock_disponible ?? 0 > 0)
                <a href="{{ route('alumno.reservas.create', $libro->id) }}" class="btn btn-success">Reservar Libro</a>
            @else
                <button class="btn btn-secondary" disabled>Agotado</button>
            @endif
        </div>
    </div>
</div>
@endsection
