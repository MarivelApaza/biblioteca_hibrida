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
    /* CONTENEDOR GENERAL */
    .apunte-shell{
        max-width: 1120px;
        margin: 0 auto;
        padding: 1rem 0 2rem;
    }

    .apunte-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:1rem;
    }
    .apunte-title{
        font-size:1.5rem;
        font-weight:700;
        color:#111827;
    }
    .apunte-subtitle{
        font-size:.9rem;
        color:#4b5563;
    }
    .apunte-tag{
        font-size:.8rem;
        padding:.35rem .9rem;
        border-radius:999px;
        background:#111827;
        color:#e5e7eb;
        display:inline-flex;
        align-items:center;
        box-shadow:0 8px 18px rgba(15,23,42,.55);
        white-space:nowrap;
    }

    /* LIBRO ABIERTO */
    .apunte-book-wrapper{
        position:relative;
        margin-top:.5rem;
    }
    .apunte-book-shadow{
        position:absolute;
        inset:10px 20px 0 20px;
        background:radial-gradient(circle at center,#9ca3af33,#00000000 60%);
        filter:blur(14px);
        z-index:0;
        pointer-events:none;
    }

    .apunte-book{
        position:relative;
        z-index:1;
        display:grid;
        grid-template-columns:1fr 1fr;
        border-radius:22px;
        background:#fefdf9;
        box-shadow:0 22px 55px rgba(15,23,42,.25);
        overflow:hidden;
        border:1px solid #e5e7eb;
    }

    .apunte-page{
        position:relative;
        padding:1.8rem 2rem 2rem;
        background:repeating-linear-gradient(
            to bottom,
            #ffffff,
            #ffffff 28px,
            #f3f4f6 29px
        );
    }
    .apunte-page-left{
        border-right:1px solid #e5e7eb;
        background:
            linear-gradient(to right, #fdfcf7 0, #f9fafb 20%, #fefce9 100%),
            repeating-linear-gradient(to bottom,#ffffff,#ffffff 28px,#f3f4f6 29px);
    }
    .apunte-page-right{
        background:
            linear-gradient(to left, #fdfcf7 0, #f9fafb 20%, #fefce9 100%),
            repeating-linear-gradient(to bottom,#ffffff,#ffffff 28px,#f3f4f6 29px);
    }

    /* LÍNEA CENTRAL (lomo) */
    .apunte-book::before{
        content:"";
        position:absolute;
        top:0;
        bottom:0;
        left:50%;
        width:3px;
        transform:translateX(-50%);
        background:linear-gradient(to bottom,#e5e7eb,#cbd5f5,#e5e7eb);
        box-shadow:0 0 4px rgba(0,0,0,.15);
        z-index:2;
    }

    .apunte-page-inner{
        position:relative;
        z-index:1;
    }

    .apunte-page-title{
        font-size:1rem;
        font-weight:600;
        color:#111827;
        margin-bottom:1rem;
    }

    .apunte-label{
        font-size:.82rem;
        font-weight:600;
        color:#374151;
        margin-bottom:.2rem;
        display:block;
    }

    .apunte-input{
        border-radius:12px;
        border:1px solid #e5e7eb;
        background:#f9fafb;
        font-size:.9rem;
    }
    .apunte-input:focus{
        border-color:#a5b4fc;
        box-shadow:0 0 0 .16rem rgba(129,140,248,.35);
        background:#ffffff;
    }

    .apunte-note-tip{
        font-size:.8rem;
        color:#6b7280;
        font-style:italic;
    }

    /* TEXTAREA CON EFECTO “CUADRICULADO” */
    .apunte-textarea{
        min-height:260px;
        border-radius:14px;
        border:1px solid #e5e7eb;
        background:
            linear-gradient(#e5e7eb 1px, transparent 1px),
            linear-gradient(90deg, #e5e7eb 1px, transparent 1px),
            #fdfdfb;
        background-size:100% 32px, 32px 100%;
        font-size:.95rem;
        line-height:2;
        padding:0.75rem 1rem;
        resize:vertical;
    }
    .apunte-textarea:focus{
        border-color:#60a5fa;
        box-shadow:0 0 0 .18rem rgba(96,165,250,.35);
        outline:none;
        background-color:#ffffff;
    }

    /* RESPONSIVE */
    @media (max-width: 992px){
        .apunte-book{
            grid-template-columns:1fr;
        }
        .apunte-book::before{
            display:none;
        }
        .apunte-page-left{
            border-right:none;
            border-bottom:1px solid #e5e7eb;
        }
    }

    @media (max-width: 576px){
        .apunte-shell{
            padding-inline:.25rem;
        }
        .apunte-page{
            padding:1.4rem 1.1rem 1.6rem;
        }
    }
</style>
@endpush
