@extends('layouts.admin')

@section('title', 'Detalle del Préstamo Físico')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book-reader"></i> Detalle del Préstamo Físico</h1>

    <div class="card shadow-lg">
        <div class="card-body">

            {{-- Datos del Alumno --}}
            <div class="mb-3">
                <label><strong>Alumno:</strong></label>
                <input type="text" class="form-control" 
                       value="{{ $prestamo->alumno->nombres }} {{ $prestamo->alumno->apellidos }} ({{ $prestamo->alumno->dni }})"
                       disabled>
            </div>

            {{-- Datos del Libro --}}
            <div class="mb-3">
                <label><strong>Libro:</strong></label>
                <input type="text" class="form-control" 
                       value="{{ $prestamo->libroFisico->titulo }} ({{ $prestamo->libroFisico->ubicacion_pasillo }})"
                       disabled>
            </div>

            {{-- Fechas --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label><strong>Fecha de Salida:</strong></label>
                    <input type="text" class="form-control" value="{{ $prestamo->fecha_salida }}" disabled>
                </div>
                <div class="col-md-6">
                    <label><strong>Fecha Devolución Programada:</strong></label>
                    <input type="text" class="form-control" value="{{ $prestamo->fecha_devolucion_programada }}" disabled>
                </div>
            </div>

            {{-- Fecha de devolución real --}}
            <div class="mb-3">
                <label><strong>Fecha de Devolución Real:</strong></label>
                <input type="text" class="form-control" 
                       value="{{ $prestamo->fecha_devolucion_real ?? 'No devuelto' }}" disabled>
            </div>

            {{-- Estado --}}
            <div class="mb-3">
                <label><strong>Estado:</strong></label>
                <input type="text" class="form-control" value="{{ $prestamo->estado }}" disabled>
            </div>

            {{-- Observaciones --}}
            <div class="mb-3">
                <label><strong>Observaciones:</strong></label>
                <textarea class="form-control" rows="3" disabled>{{ $prestamo->observaciones_devolucion ?? 'Sin observaciones' }}</textarea>
            </div>

            <a href="{{ route('admin.prestamos_fisicos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
@endsection
