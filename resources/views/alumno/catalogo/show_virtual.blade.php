@extends('layouts.alumno')

@section('title', 'Detalles del Libro Virtual')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0">

        {{-- CABECERA --}}
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">
                <i class="fas fa-tablet-alt"></i> {{ $libro->titulo }}
            </h4>
        </div>

        <div class="card-body row">

            <!-- Imagen -->
            <div class="col-md-4 text-center">
                <img src="{{ $libro->imagen_portada 
                        ? asset('storage/' . $libro->imagen_portada) 
                        : asset('img/no-image.png') }}"
                     class="img-fluid rounded shadow"
                     style="max-height: 350px; object-fit: contain;">
            </div>

            <!-- Información del Libro -->
            <div class="col-md-8">

                <h5 class="mb-3"><strong>Información del Libro</strong></h5>

                <p><strong>Autor:</strong> {{ $libro->autor }}</p>

                <p>
                    <strong>Categoría:</strong> 
                    {{ $libro->categoria->nombre ?? 'Sin categoría' }}
                </p>

                <p><strong>Peso del archivo:</strong> {{ $libro->peso_archivo }} MB</p>
                <p><strong>Palabras clave:</strong> {{ $libro->palabras_clave }}</p>

                <hr>

                <h5><strong>Sinopsis</strong></h5>
                <p>
                    {{ $libro->resumen_sinopsis ?? 'No se ha registrado sinopsis para este libro.' }}
                </p>

                <hr>

                {{-- BOTÓN PARA GENERAR ACCESO --}}
                <form action="{{ route('alumno.accesos.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_libro_virtual" value="{{ $libro->id_libro_virtual }}">

                    <button type="submit" class="btn btn-success mt-2">
                        <i class="fas fa-unlock"></i> Generar acceso (válido 7 días)
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>
@endsection
