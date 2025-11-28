@extends('layouts.admin')

@section('title', 'Editar Préstamo Físico')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book-reader"></i> Editar Préstamo Físico</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.prestamos_fisicos.update', $prestamo->id_prestamo) }}">
                @csrf
                @method('PUT')

                {{-- Datos del Alumno --}}
                <div class="mb-3">
                    <label><strong>Alumno:</strong></label>
                    <input type="text" 
                        class="form-control" 
                        value="
                                {{ $prestamo->usuario->nombres ?? 'Sin nombre' }} 
                                {{ $prestamo->usuario->apellidos ?? '' }} 
                                ({{ $prestamo->usuario->dni ?? '---' }})
                        "
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
                        <label for="fecha_salida"><strong>Fecha de Salida:</strong></label>
                        <input type="text" class="form-control" 
                               value="{{ $prestamo->fecha_salida }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_devolucion_programada"><strong>Fecha Devolución Programada:</strong></label>
                        <input type="text" class="form-control" 
                               value="{{ $prestamo->fecha_devolucion_programada }}" disabled>
                    </div>
                </div>

                {{-- Fecha de devolución real --}}
                <div class="mb-3">
                    <label for="fecha_devolucion_real"><strong>Fecha de Devolución Real:</strong></label>
                    <input type="datetime-local" name="fecha_devolucion_real" id="fecha_devolucion_real" 
                           class="form-control" 
                           value="{{ $prestamo->fecha_devolucion_real ? date('Y-m-d\TH:i', strtotime($prestamo->fecha_devolucion_real)) : '' }}">
                </div>

                {{-- Estado --}}
                <div class="mb-3">
                    <label for="estado"><strong>Estado:</strong></label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="PENDIENTE" {{ $prestamo->estado == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                        <option value="DEVUELTO" {{ $prestamo->estado == 'DEVUELTO' ? 'selected' : '' }}>Devuelto</option>
                        <option value="MORA" {{ $prestamo->estado == 'MORA' ? 'selected' : '' }}>Mora</option>
                    </select>
                </div>

                {{-- Observaciones --}}
                <div class="mb-3">
                    <label for="observaciones_devolucion"><strong>Observaciones:</strong></label>
                    <textarea name="observaciones_devolucion" id="observaciones_devolucion" 
                              class="form-control" rows="3">{{ $prestamo->observaciones_devolucion }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('admin.prestamos_fisicos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </form>
        </div>
    </div>
</div>
<br><br>
@endsection


@push('styles')
<style>
/* ==========================================
   🎨 TÍTULO PRINCIPAL
========================================== */
h1.mb-4 {
    color: #045d75 !important;
    font-weight: 900;
    text-shadow: 0 1px 2px rgba(0,0,0,0.10);
    letter-spacing: .5px;
}

/* ==========================================
   🎨 TARJETA FORMULARIO
========================================== */
form {
    background: #ffffff;
    padding: 2rem 2.2rem;
    border-radius: 1.4rem;
    border: 1px solid #c9eef7;
    box-shadow: 0 10px 25px rgba(4, 93, 117, 0.12);
}

/* ==========================================
   🎨 LABELS
========================================== */
.form-label {
    font-weight: 700;
    font-size: .95rem;
    color: #04445c;
    margin-bottom: .35rem;
}

/* ==========================================
   🎨 INPUTS & TEXTAREAS
========================================== */
.form-control, .form-select {
    border-radius: .9rem !important;
    border: 1px solid #bce5f0 !important;
    background: #f9fdff !important;
    padding: .65rem .9rem !important;
    font-size: .95rem;
    color: #04445c;
}

.form-control:focus, .form-select:focus {
    border-color: #73d2f6 !important;
    box-shadow: 0 0 0 .18rem rgba(115,210,246,.32) !important;
    background: #ffffff !important;
}

/* ==========================================
   🎨 TEXTAREA ESPECIAL SUAVE
========================================== */
textarea.form-control {
    background: linear-gradient(#f7fcff 0%, #ffffff 100%);
    border-radius: 1rem;
}

/* ==========================================
   🎨 BOTÓN GUARDAR – VERDE PASTEL
========================================== */
.btn-success {
    background: linear-gradient(135deg, #7be5b6, #47c78d) !important;
    border: none !important;
    color: #023f30 !important;
    padding: .65rem 1.5rem !important;
    border-radius: .9rem !important;
    font-weight: 700;
    box-shadow: 0 6px 20px rgba(71,199,141,0.35);
    transition: .2s ease-in-out;
}

.btn-success:hover {
    background: linear-gradient(135deg, #66dba6, #38b87e) !important;
    transform: translateY(-2px);
}

/* ==========================================
   🎨 BOTÓN CANCELAR – GRIS TURQUESA
========================================== */
.btn-secondary {
    background: #e7f7fb !important;
    border: none !important;
    color: #045d75 !important;
    padding: .65rem 1.5rem !important;
    border-radius: .9rem !important;
    font-we

</style>
@endpush