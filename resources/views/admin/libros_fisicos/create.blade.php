@extends('layouts.admin')

@section('title', 'Nuevo Libro Físico')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-plus"></i> Crear Libro Físico</h1>

    <form action="{{ route('admin.libros_fisicos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" id="titulo" required>
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" class="form-control" name="autor" id="autor" required>
        </div>

        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select name="id_categoria" id="id_categoria" class="form-control" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" id="isbn">
        </div>

        <div class="mb-3">
            <label for="editorial" class="form-label">Editorial</label>
            <input type="text" class="form-control" name="editorial" id="editorial">
        </div>

        <div class="mb-3">
            <label for="año_edicion" class="form-label">Año de Edición</label>
            <input type="number" class="form-control" name="año_edicion" id="año_edicion">
        </div>

        <div class="mb-3">
            <label for="tipo_encuadernacion" class="form-label">Tipo de Encuadernación</label>
            <select name="tipo_encuadernacion" id="tipo_encuadernacion" class="form-control">
                <option value="TAPA_DURA">Tapa Dura</option>
                <option value="RUSTICA">Rústica</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado_promedio" class="form-label">Estado</label>
            <select name="estado_promedio" id="estado_promedio" class="form-control">
                <option value="NUEVO">Nuevo</option>
                <option value="BUENO">Bueno</option>
                <option value="REGULAR">Regular</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="stock_total" class="form-label">Stock Total</label>
            <input type="number" class="form-control" name="stock_total" id="stock_total" required>
        </div>

        <div class="mb-3">
            <label for="stock_disponible" class="form-label">Stock Disponible</label>
            <input type="number" class="form-control" name="stock_disponible" id="stock_disponible" required>
        </div>

        <div class="mb-3">
            <label for="ubicacion_pasillo" class="form-label">Ubicación / Pasillo</label>
            <input type="text" class="form-control" name="ubicacion_pasillo" id="ubicacion_pasillo">
        </div>

        <div class="mb-3">
            <label for="imagen_portada" class="form-label">Imagen de Portada</label>
            <input type="file" class="form-control" name="imagen_portada" id="imagen_portada">
        </div>

        <div class="mb-3">
            <label for="palabras_clave" class="form-label">Palabras Clave</label>
            <textarea class="form-control" name="palabras_clave" id="palabras_clave" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Libro</button>
        <a href="{{ route('admin.libros_fisicos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<br>
@endsection

@push('styles')
<style>

/* ==========================================
   🎨 TÍTULO
========================================== */
h1.mb-4 {
    color: #04445c !important;
    font-weight: 900 !important;
}

/* ==========================================
   🎨 FORMULARIO CONTENEDOR
========================================== */
.container-fluid {
    max-width: 900px;
}

/* ==========================================
   🎨 LABELS
========================================== */
.form-label {
    font-weight: 700 !important;
    color: #03516a !important;
}

/* ==========================================
   🎨 INPUTS Y SELECTS – PASTELES
========================================== */
.form-control, .form-select, textarea {
    border-radius: .85rem !important;
    border-color: #b7e6f5 !important;
    background: #f9feff !important;
}

.form-control:focus, .form-select:focus, textarea:focus {
    border-color: #55cdf4 !important;
    box-shadow: 0 0 0 .18rem rgba(0,170,255,.25) !important;
    background: #ffffff !important;
}

/* ==========================================
   🎨 CARD DE LOS INPUTS
========================================== */
.card, .shadow-lg {
    border-radius: 1.3rem !important;
    border: 1px solid #c7e9f7 !important;
    background: #ffffffee !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
}

/* ==========================================
   🎨 BOTONES PASTELES
========================================== */

/* Guardar */
.btn-success {
    background: #99f0c7 !important;
    border-color: #99f0c7 !important;
    color: #0b623e !important;
    border-radius: .9rem !important;
    font-weight: 700 !important;
}

.btn-success:hover {
    background: #7ceab2 !important;
    color: #06492c !important;
}

/* Cancelar */
.btn-secondary {
    background: #d8f0ff !important;
    border-color: #d8f0ff !important;
    color: #044766 !important;
    border-radius: .9rem !important;
    font-weight: 700 !important;
}

.btn-secondary:hover {
    background: #c8e6ff !important;
}

/* ==========================================
   🎨 IMAGEN MINIATURA
========================================== */
.img-thumbnail {
    border-radius: .8rem !important;
    border-color: #a4daef !important;
    background: #f1fcff !important;
}

/* ==========================================
   🎨 TEXTAREA
========================================== */
textarea {
    resize: none !important;
}

/* ==========================================
   🎨 SPACING
========================================== */
.mb-3 input, 
.mb-3 select, 
.mb-3 textarea {
    padding: .75rem 1rem !important;
    font-size: 1rem !important;
}

/* ==========================================
   🎨 PLACEHOLDER
========================================== */
::placeholder {
    color: #6aa7b4 !important;
    opacity: .7 !important;
}

</style>
@endpush
