@extends('layouts.admin')

@section('title', 'Devolver Libro')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-undo-alt"></i> Devolver Libro</h1>

    <div class="card shadow-lg">
        <div class="card-body">

            {{-- Información del préstamo --}}
            <div class="mb-3">
                <strong>Alumno:</strong> {{ $prestamo->usuario->nombres }} {{ $prestamo->usuario->apellidos }}<br>
                <strong>Libro:</strong> {{ $prestamo->libroFisico->titulo }}<br>
                <strong>Fecha de salida:</strong> {{ $prestamo->fecha_salida->format('d/m/Y H:i') }}<br>
                <strong>Fecha de devolución programada:</strong> {{ $prestamo->fecha_devolucion_programada->format('d/m/Y') }}<br>
                <strong>Estado actual:</strong> {{ $prestamo->estado }}
            </div>

            {{-- Formulario de devolución --}}
            <form action="{{ route('admin.prestamos_fisicos.devolver', $prestamo->id_prestamo) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="fecha_devolucion_real" class="form-label"><strong>Fecha de devolución real:</strong></label>
                    <input type="datetime-local" 
                           id="fecha_devolucion_real" 
                           name="fecha_devolucion_real" 
                           class="form-control @error('fecha_devolucion_real') is-invalid @enderror"
                           value="{{ old('fecha_devolucion_real', now()->format('Y-m-d\TH:i')) }}"
                           required>
                    @error('fecha_devolucion_real')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="observaciones_devolucion" class="form-label"><strong>Observaciones:</strong></label>
                    <textarea name="observaciones_devolucion" 
                              id="observaciones_devolucion" 
                              class="form-control @error('observaciones_devolucion') is-invalid @enderror"
                              rows="3" 
                              placeholder="Detalles sobre el estado del libro...">{{ old('observaciones_devolucion', $prestamo->observaciones_devolucion) }}</textarea>
                    @error('observaciones_devolucion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="estado" value="DEVUELTO">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.prestamos_fisicos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Marcar Devuelto
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

/* ================================
   🎨 TITULO
================================ */
h1.mb-4 {
    color: #035a70 !important;
    font-weight: 900;
}

/* ================================
   🎨 CARD PASTEL
================================ */
.card {
    border-radius: 1.2rem !important;
    background: #ffffffee !important;
    border: 1px solid #bde9f5 !important;
    box-shadow: 0 10px 24px rgba(0,0,0,0.08) !important;
}

/* ================================
   🎨 TEXTOS DE INFORMACIÓN
================================ */
.card-body strong {
    color: #04445c;
}

.card-body {
    font-size: .95rem;
    color: #305b65;
}

/* ================================
   🎨 INPUTS PASTEL
================================ */
.form-control {
    border-radius: .9rem !important;
    border: 1px solid #cdebf4 !important;
    background: #f8fdff !important;
    transition: .2s ease;
}

.form-control:focus {
    border-color: #6cd4ff !important;
    box-shadow: 0 0 0 .18rem rgba(108,212,255,.35) !important;
    background: #ffffff !important;
}

/* ================================
   🎨 BOTÓN PRINCIPAL (Confirmar)
================================ */
.btn-success {
    background: #7be4c0 !important;
    border-color: #7be4c0 !important;
    color: #0a3f32 !important;
    border-radius: .8rem !important;
    font-weight: 600 !important;
}

.btn-success:hover {
    background: #5ed8ab !important;
}

/* ================================
   🎨 BOTÓN SECUNDARIO (Volver)
================================ */
.btn-secondary {
    background: #d9f2f8 !important;
    border-color: #c7e7ee !important;
    color: #04445c !important;
    border-radius: .8rem !important;
    font-weight: 600 !important;
}

.btn-secondary:hover {
    background: #c8edf7 !important;
}

/* ================================
   🎨 ÁREA DE TEXTO
================================ */
textarea.form-control {
    background: #f7fcff !important;
}

/* ================================
   🎨 SEPARACIÓN ENTRE BLOQUES
================================ */
.mb-3 label {
    color: #04445c;
    font-weight: 600;
}

</style>
@endpush
