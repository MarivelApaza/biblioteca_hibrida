@extends('layouts.alumno')

@section('title', 'Generar Acceso Virtual')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h3 class="fw-bold mb-2">
                <i class="fas fa-file-pdf me-2"></i> Generar acceso virtual
            </h3>

            <p class="text-muted">
                Estás por generar un acceso de 7 días para el libro:
            </p>

            <div class="p-3 bg-light rounded mb-3">
                <h5 class="mb-1">{{ $libro->titulo }}</h5>
                <p class="mb-0">
                    <i class="fas fa-user me-2"></i>{{ $libro->autor }}
                </p>
            </div>

            <form action="{{ route('alumno.accesos.store') }}" method="POST">
                @csrf

                <input type="hidden" name="id_libro_virtual" value="{{ $libro->id_libro_virtual }}">

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Este acceso será válido por <strong>7 días</strong> y no podrá regenerarse hasta que expire.
                </div>

                <button class="btn btn-success w-100">
                    <i class="fas fa-check me-2"></i>
                    Confirmar y generar acceso
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
