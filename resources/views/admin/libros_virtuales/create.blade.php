@extends('layouts.admin')

@section('title', 'Nuevo Libro Virtual')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-plus"></i> Crear Libro Virtual</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>📌 {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.libros_virtuales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- TÍTULO --}}
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" id="titulo" 
                   value="{{ old('titulo') }}" required>
        </div>

        {{-- AUTOR --}}
        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" class="form-control" name="autor" id="autor" 
                   value="{{ old('autor') }}" required>
        </div>

        {{-- CATEGORÍA --}}
        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select name="id_categoria" id="id_categoria" class="form-control" required>
                <option value="">-- Seleccione una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}"
                        {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SINOPSIS --}}
        <div class="mb-3">
            <label for="resumen_sinopsis" class="form-label">Resumen / Sinopsis</label>
            <textarea class="form-control" name="resumen_sinopsis" id="resumen_sinopsis" 
                      rows="3" required>{{ old('resumen_sinopsis') }}</textarea>
        </div>

        {{-- URL DEL ARCHIVO --}}
        <div class="mb-3">
            <label for="url_archivo" class="form-label">URL del Archivo (PDF / Google Drive)</label>
            <input type="url" class="form-control" name="url_archivo" id="url_archivo"
                   value="{{ old('url_archivo') }}"
                   placeholder="https://drive.google.com/..."
                   required>
        </div>

        {{-- PESO DEL ARCHIVO --}}
        <div class="mb-3">
            <label for="peso_archivo" class="form-label">Peso del Archivo (MB)</label>
            <input type="number" step="0.01" min="0" class="form-control" 
                   name="peso_archivo" id="peso_archivo" 
                   value="{{ old('peso_archivo') }}">
            <small class="text-muted">Ejemplo: 12.5</small>
        </div>

        {{-- PORTADA --}}
        <div class="mb-3">
            <label for="imagen_portada" class="form-label">Imagen de Portada</label>
            <input type="file" class="form-control" name="imagen_portada" 
                   id="imagen_portada" accept="image/*">
        </div>

        {{-- PALABRAS CLAVE --}}
        <div class="mb-3">
            <label for="palabras_clave" class="form-label">Palabras Clave</label>
            <textarea class="form-control" name="palabras_clave" id="palabras_clave" 
                      rows="2" required>{{ old('palabras_clave') }}</textarea>
        </div>

        {{-- BOTONES --}}
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar Libro Virtual
        </button>

        <a href="{{ route('admin.libros_virtuales.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
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