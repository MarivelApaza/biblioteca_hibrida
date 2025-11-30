@extends('layouts.admin')

@section('title', 'Editar Libro Virtual')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-edit"></i> Editar Libro Virtual</h1>

    {{-- ERRORES --}}
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

    <form action="{{ route('admin.libros_virtuales.update', $libro->id_libro_virtual) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- TÍTULO --}}
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" id="titulo"
                   value="{{ $libro->titulo }}" required>
        </div>

        {{-- AUTOR --}}
        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" class="form-control" name="autor" id="autor"
                   value="{{ $libro->autor }}" required>
        </div>

        {{-- CATEGORÍA --}}
        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select name="id_categoria" id="id_categoria" class="form-control" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}"
                        {{ $libro->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SINOPSIS --}}
        <div class="mb-3">
            <label for="resumen_sinopsis" class="form-label">Resumen / Sinopsis</label>
            <textarea class="form-control" name="resumen_sinopsis" id="resumen_sinopsis"
                      rows="3">{{ $libro->resumen_sinopsis }}</textarea>
        </div>

        {{-- URL DEL ARCHIVO --}}
        <div class="mb-3">
            <label for="url_archivo" class="form-label">URL del Archivo (PDF / Google Drive)</label>
            <input type="url" class="form-control" name="url_archivo"
                   id="url_archivo"
                   value="{{ $libro->url_archivo }}"
                   placeholder="https://drive.google.com/..." required>
            @if($libro->url_archivo)
                <a href="{{ $libro->url_archivo }}" target="_blank" class="btn btn-info btn-sm mt-2">
                    Ver archivo actual
                </a>
            @endif
        </div>

        {{-- PESO ARCHIVO --}}
        <div class="mb-3">
            <label for="peso_archivo" class="form-label">Peso del Archivo (MB)</label>
            <input type="text" class="form-control" name="peso_archivo"
                   id="peso_archivo" value="{{ $libro->peso_archivo }}">
        </div>

        {{-- PORTADA --}}
        <div class="mb-3">
            <label for="imagen_portada" class="form-label">Imagen de Portada</label>
            <input type="file" class="form-control" name="imagen_portada"
                   id="imagen_portada" accept="image/*">

            @if($libro->imagen_portada)
                <img src="{{ asset('storage/'.$libro->imagen_portada) }}"
                     class="img-thumbnail mt-2" width="130">
            @endif
        </div>

        {{-- PALABRAS CLAVE --}}
        <div class="mb-3">
            <label for="palabras_clave" class="form-label">Palabras Clave</label>
            <textarea class="form-control" name="palabras_clave"
                      id="palabras_clave" rows="2">{{ $libro->palabras_clave }}</textarea>
        </div>

        {{-- BOTONES --}}
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Actualizar Libro Virtual
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
h1.mb-4 {
    color: #045d75 !important;
    font-weight: 900;
    text-shadow: 0 1px 2px rgba(0,0,0,0.10);
    letter-spacing: .5px;
}
form {
    background: #ffffff;
    padding: 2rem 2.2rem;
    border-radius: 1.4rem;
    border: 1px solid #c9eef7;
    box-shadow: 0 10px 25px rgba(4, 93, 117, 0.12);
}
.form-label {
    font-weight: 700;
    font-size: .95rem;
    color: #04445c;
}
.form-control, .form-select {
    border-radius: .9rem !important;
    border: 1px solid #bce5f0 !important;
    background: #f9fdff !important;
    padding: .65rem .9rem !important;
    color: #04445c !important;
}
.form-control:focus {
    border-color: #73d2f6 !important;
    box-shadow: 0 0 0 .18rem rgba(115,210,246,.32) !important;
}
textarea.form-control {
    background: linear-gradient(#f7fcff 0%, #ffffff 100%);
    border-radius: 1rem;
}
.btn-success {
    background: linear-gradient(135deg, #7be5b6, #47c78d) !important;
    border: none !important;
    color: #023f30 !important;
    padding: .65rem 1.5rem;
    border-radius: .9rem !important;
    font-weight: 700;
    box-shadow: 0 6px 20px rgba(71,199,141,0.35);
}
.btn-success:hover {
    background: linear-gradient(135deg, #66dba6, #38b87e) !important;
    transform: translateY(-2px);
}
.btn-secondary {
    background: #e7f7fb !important;
    color: #045d75 !important;
    padding: .65rem 1.5rem;
    border-radius: .9rem !important;
}
</style>
@endpush
