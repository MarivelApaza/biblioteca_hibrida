@extends('layouts.admin')

@section('title', 'Nueva Categoría')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-plus"></i> Crear Categoría</h1>

    <form action="{{ route('admin.categorias.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_categoria" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" name="nombre_categoria" id="nombre_categoria" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Categoría</button>
        <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<br>
<br>
@endsection
@push('styles')
<style>
/* ==========================================
   💠 TÍTULO PRINCIPAL
========================================== */
h1.mb-4 {
    color: #05668d !important;
    font-weight: 900 !important;
    letter-spacing: .5px;
    text-shadow: 1px 1px 2px #c8f5ff;
}

/* ==========================================
   💠 FORMULARIO / TARJETA
========================================== */
form {
    background: #ffffff;
    border-radius: 1.4rem;
    padding: 2rem;
    border: 1px solid #bdeaf7;
    box-shadow: 0 10px 25px rgba(0, 91, 128, 0.12);
    max-width: 700px;
}

/* ==========================================
   💠 LABELS
========================================== */
.form-label {
    font-weight: 700;
    color: #04445c;
    margin-bottom: .35rem;
    font-size: .95rem;
}

/* ==========================================
   💠 INPUTS Y TEXTAREA
========================================== */
.form-control {
    border-radius: .9rem !important;
    border: 1px solid #bae6f3 !important;
    background: #f9fdff !important;
    padding: .65rem .9rem !important;
    font-size: .95rem;
    color: #04445c;
}

.form-control:focus {
    border-color: #73d2f6 !important;
    box-shadow: 0 0 0 .18rem rgba(115,210,246,.32) !important;
    background: #ffffff !important;
}

/* ==========================================
   💠 BOTÓN GUARDAR (Verde Pastel)
========================================== */
.btn-success {
    background: linear-gradient(135deg, #79e2b3, #44c48c) !important;
    border: none !important;
    border-radius: .9rem !important;
    font-weight: 700;
    color: #034536 !important;
    padding: .65rem 1.4rem !important;
    box-shadow: 0 6px 20px rgba(68,196,140,0.35);
    transition: .2s ease-in-out;
}

.btn-success:hover {
    background: linear-gradient(135deg, #63d8a3, #37b47d) !important;
    transform: translateY(-2px);
}

/* ==========================================
   💠 BOTÓN CANCELAR (Gris Pastel)
========================================== */
.btn-secondary {
    background: #e7f5fa !important;
    border: none !important;
    border-radius: .9rem;
    color: #05506b !important;
    font-weight: 600;
    padding: .65rem 1.4rem !important;
    transition: .2s ease;
}

.btn-secondary:hover {
    background: #d4eef7 !important;
    transform: translateY(-2px);
}

</style>
@endpush