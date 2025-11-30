@extends('layouts.alumno')
@section('title', 'Nuevo Apunte')

@section('content')
<div class="apunte-shell">

    {{-- CABECERA --}}
    <div class="apunte-header mb-4">
        <div>
            <h1 class="apunte-title mb-1">
                <i class="fas fa-pen-fancy me-2"></i> Nuevo Apunte
            </h1>
            <p class="apunte-subtitle mb-0">
                Crea notas personales sobre tus libros virtuales. Imagina que escribes directamente en los márgenes del libro. ✍️
            </p>
        </div>
        <div class="apunte-tag">
            <i class="fas fa-book-open me-1"></i> Biblioteca Virtual 
        </div>
    </div>

    {{-- LIBRO ABIERTO --}}
    <div class="apunte-book-wrapper">
        <div class="apunte-book-shadow"></div>

        <div class="apunte-book">
            {{-- Página izquierda: información del libro --}}
            <div class="apunte-page apunte-page-left">
                <div class="apunte-page-inner">
                    <h2 class="apunte-page-title">
                        <i class="fas fa-book me-2"></i> Datos del libro
                    </h2>

                    <form id="formApunte" action="{{ route('alumno.apuntes.store') }}" method="POST">
                        @csrf

                        {{-- LIBRO --}}
                        <div class="mb-3">
                            <label class="apunte-label" for="id_libro_virtual">Libro</label>
                            <select name="id_libro_virtual" id="id_libro_virtual"
                                    class="form-select apunte-input" required>
                                <option value="">— Selecciona un libro —</option>
                                @foreach($libros as $libro)
                                    <option value="{{ $libro->id_libro_virtual }}"
                                        {{ (isset($libroSeleccionado) && $libroSeleccionado->id_libro_virtual == $libro->id_libro_virtual) ? 'selected' : '' }}>
                                        {{ $libro->titulo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_libro_virtual')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- PÁGINA --}}
                        <div class="mb-3">
                            <label class="apunte-label" for="pagina_pdf">Página (opcional)</label>
                            <input type="number" name="pagina_pdf" id="pagina_pdf"
                                   class="form-control apunte-input"
                                   placeholder="Ej. 15"
                                   value="{{ old('pagina_pdf') }}">
                            @error('pagina_pdf')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted d-block mt-1" style="font-size:.75rem;">
                                Puedes indicar la página del PDF donde estás tomando este apunte.
                            </small>
                        </div>

                        {{-- mini leyenda --}}
                        <p class="apunte-note-tip mt-4 mb-0">
                            Consejo: intenta resumir la idea principal de la página en una o dos frases.
                        </p>
                    </form>
                </div>
            </div>

            {{-- Página derecha: texto del apunte --}}
            <div class="apunte-page apunte-page-right">
                <div class="apunte-page-inner">
                    <h2 class="apunte-page-title">
                        <i class="fas fa-highlighter me-2"></i> Texto del apunte
                    </h2>

                    <div class="mb-3">
                        <label class="apunte-label" for="texto_nota">Escribe tu nota</label>
                        <textarea name="texto_nota" id="texto_nota"
                                  form="formApunte"
                                  class="form-control apunte-textarea"
                                  rows="10"
                                  placeholder="Escribe aquí tus ideas, resúmenes o frases importantes del libro...">{{ old('texto_nota') }}</textarea>
                        @error('texto_nota')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Botones en “marcapáginas” --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('alumno.apuntes.index') }}"
                           class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Volver a mis apuntes
                        </a>

                        <div class="d-flex gap-2">
                            <button type="reset" 
                                    form="formApunte"
                                    class="btn btn-light border rounded-pill px-4">
                                <i class="fas fa-eraser me-1"></i> Limpiar
                            </button>

                            <button type="submit" form="formApunte"
                                    class="btn btn-success rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Guardar apunte
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('styles')
<style>

/* ===============================
   📘 CONTENEDOR GENERAL
================================ */
.apunte-shell {
    max-width: 1180px;
    margin: 0 auto;
    padding: 1rem 0 2rem;
}

/* ===============================
   📘 CABECERA
================================ */
.apunte-title {
    font-weight: 900;
    color: #063c4f;
    text-shadow: 0 2px 6px rgba(0, 70, 90, 0.15);
}

.apunte-subtitle {
    color: #52717c;
    font-style: italic;
}

.apunte-tag {
    background: linear-gradient(135deg, #066b7a, #044755);
    border: 1px solid #7de3e0;
    padding: .4rem 1rem;
    border-radius: 999px;
    font-weight: 600;
    color: #eaffff;
    box-shadow: 0 6px 18px rgba(3, 70, 80, .35);
}

/* ===============================
   📘 LIBRO ABIERTO (MEJORADO)
================================ */
.apunte-book-wrapper {
    position: relative;
    margin-top: 1rem;
}

.apunte-book {
    position: relative;
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 22px;
    background: #fcfcf9;
    overflow: hidden;
    border: 1px solid #d7f2f7;
    box-shadow:
        0 18px 40px rgba(0, 60, 70, .22),
        0 0 12px rgba(125, 227, 224, .25) inset;
    transform: perspective(900px) rotateX(0deg);
    transition: .4s ease;
}

.apunte-book:hover {
    transform: perspective(850px) rotateX(1.5deg);
}

/* Sombra exterior */
.apunte-book-shadow {
    position: absolute;
    inset: 18px 30px 0 30px;
    background: radial-gradient(circle at center, #a2bcc733 15%, transparent 70%);
    filter: blur(16px);
    pointer-events: none;
}

/* ===============================
   📘 LOMO CENTRAL (3D REALISTA)
================================ */
.apunte-book::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 22px;
    transform: translateX(-50%);
    background: linear-gradient(
        to bottom,
        #e3eef0,
        #d0e7ea,
        #c0dde0,
        #d0e7ea,
        #e3eef0
    );
    box-shadow:
        inset 0 0 8px rgba(0, 0, 0, .15),
        0 0 8px rgba(0, 0, 0, .05);
    border-left: 1px solid #d9f2f7;
    border-right: 1px solid #d9f2f7;
    z-index: 2;
}

/* ===============================
   📘 PÁGINAS
================================ */
.apunte-page {
    padding: 2.2rem 2.2rem 2rem;
    position: relative;
    background: repeating-linear-gradient(
            to bottom,
            #ffffff,
            #ffffff 26px,
            #f2f6f8 27px
        );
    transition: .3s ease;
}

/* Curvatura suave */
.apunte-page-left {
    background:
        linear-gradient(to right, #fbfdfd, #eef7f9 20%, #ffffff 90%),
        repeating-linear-gradient(to bottom, #fff, #fff 26px, #f2f6f8 27px);
    border-right: 2px solid #e7f4f7;
    clip-path: polygon(0 0, 100% 0, 98% 100%, 0 100%);
}

.apunte-page-right {
    background:
        linear-gradient(to left, #fbfdfd, #eef7f9 20%, #ffffff 90%),
        repeating-linear-gradient(to bottom, #fff, #fff 26px, #f2f6f8 27px);
    clip-path: polygon(2% 0, 100% 0, 100% 100%, 0 100%);
}

/* Hover tipo “paso de página” */
.apunte-page-right:hover {
    transform: translateX(4px);
}
.apunte-page-left:hover {
    transform: translateX(-4px);
}

/* ===============================
   📘 TEXTOS Y CAMPOS
================================ */
.apunte-page-title {
    font-weight: 800;
    color: #033b47;
    text-shadow: 0 1px 3px rgba(0, 40, 55, 0.12);
}

.apunte-label {
    font-weight: 600;
    color: #083a45;
}

.apunte-input {
    border-radius: 12px;
    border: 1px solid #b8e7ef;
    background: #f8feff;
}
.apunte-input:focus {
    border-color: #79e2ec;
    box-shadow: 0 0 0 .15rem rgba(97, 236, 255, .35);
}

/* TEXTAREA efecto cuadrícula */
.apunte-textarea {
    border-radius: 14px;
    border: 1px solid #c8ebef;
    background:
        linear-gradient(#ddeff0 1px, transparent 1px),
        linear-gradient(90deg, #ddeff0 1px, transparent 1px),
        #ffffff;
    background-size: 100% 28px, 28px 100%;
}
.apunte-textarea:focus {
    border-color: #7de3eb;
    box-shadow: 0 0 0 .2rem rgba(100, 220, 235, .35);
}

/* ===============================
   📘 BOTONES (PAGINADORES)
================================ */
.btn-outline-secondary {
    border-radius: 999px !important;
}

.btn-success {
    background: linear-gradient(135deg, #a8f5e2, #56d4b9) !important;
    border: none !important;
    font-weight: 700 !important;
}

.btn-light {
    border-radius: 999px !important;
}

/* ===============================
   📘 RESPONSIVE
================================ */
@media (max-width: 992px){
    .apunte-book {
        grid-template-columns: 1fr;
    }
    .apunte-book::before {
        display:none;
    }
    .apunte-page-left {
        border-right:none;
        border-bottom: 1px solid #d9f2f7;
        clip-path:none;
    }
    .apunte-page-right {
        clip-path:none;
    }
}

</style>
@endpush
