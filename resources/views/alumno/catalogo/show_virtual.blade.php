@extends('layouts.alumno')

@section('title', 'Detalles del Libro Virtual')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0">

        {{-- CABECERA --}}
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">
                <i class="fas fa-tablet-alt"></i> {{ $libro->titulo }}
            </h4>
        </div>

        <div class="card-body row">

            <!-- Imagen -->
            <div class="col-md-4 text-center">
                <img src="{{ $libro->imagen_portada 
                        ? asset('storage/' . $libro->imagen_portada) 
                        : asset('img/no-image.png') }}"
                     class="img-fluid rounded shadow"
                     style="max-height: 350px; object-fit: contain;">
            </div>

            <!-- Información del Libro -->
            <div class="col-md-8">

                <h5 class="mb-3"><strong>Información del Libro</strong></h5>

                <p><strong>Autor:</strong> {{ $libro->autor }}</p>

                <p><strong>Categoría:</strong> {{ $libro->categoria->nombre_categoria ?? 'Sin categoría' }}</p>


                <p><strong>Peso del archivo:</strong> {{ $libro->peso_archivo }} MB</p>
                <p><strong>Palabras clave:</strong> {{ $libro->palabras_clave }}</p>

                <hr>

                <h5><strong>Sinopsis</strong></h5>
                <p>
                    {{ $libro->resumen_sinopsis ?? 'No se ha registrado sinopsis para este libro.' }}
                </p>

                <hr>

                {{-- BOTÓN PARA GENERAR ACCESO --}}
                <form action="{{ route('alumno.accesos.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_libro_virtual" value="{{ $libro->id_libro_virtual }}">

                    <button type="submit" class="btn btn-success mt-2">
                        <i class="fas fa-unlock"></i> Generar acceso (válido 7 días)
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>
@endsection
@push('styles')
<style>

/* ============================================================
   📘 TARJETA PRINCIPAL
============================================================ */
.card.shadow-lg {
    border-radius: 22px !important;
    overflow: hidden;
    border: 2px solid #c8f5ff !important;
    background: linear-gradient(145deg, #ffffff, #f6fcff);
    box-shadow: 0 10px 30px rgba(0, 115, 150, 0.15) !important;
    animation: fadeIn .6s ease;
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ============================================================
   📘 CABECERA (DEGRADADO CELESTE)
============================================================ */
.card-header.bg-info {
    background: linear-gradient(135deg, #9edff6, #6fc6e0, #b3ecff) !important;
    border-bottom: 2px solid #c8f5ff !important;
    padding: 1rem 1.2rem !important;
}

.card-header h4 {
    font-weight: 900 !important;
    letter-spacing: .5px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.25);
}

/* ============================================================
   📘 IMAGEN DEL LIBRO
============================================================ */
.img-fluid {
    border-radius: 18px !important;
    box-shadow: 0 8px 20px rgba(0, 120, 150, 0.15);
    background: #eafaff;
    padding: .4rem;
    transition: .3s ease;
}

.img-fluid:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 28px rgba(0,120,150,0.22);
}

/* ============================================================
   📘 TÍTULOS
============================================================ */
h5 {
    color: #033b47;
    font-weight: 900;
    font-size: 1.15rem;
    letter-spacing: .5px;
}

/* ============================================================
   📘 TEXTO / PÁRRAFOS
============================================================ */
p {
    color: #064663;
    font-size: .95rem;
    font-weight: 500;
}

/* Separadores suaves */
hr {
    border: 0;
    height: 1px;
    background: #d9f4ff;
    margin: 1.3rem 0;
}

/* ============================================================
   📘 BOTÓN DE GENERAR ACCESO (CELESTE PREMIUM)
============================================================ */
.btn-success {
    background: linear-gradient(135deg, #6fc6e0, #4eb4c9) !important;
    border: none !important;
    border-radius: 12px !important;
    font-weight: 800 !important;
    padding: .65rem 1.4rem !important;
    color: #ffffff !important;
    box-shadow: 0 6px 18px rgba(80, 180, 205, 0.35);
    transition: .25s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #4eb4c9, #3da2b7) !important;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(80, 180, 205, 0.45);
}

/* Icono animado */
.btn-success i {
    animation: floatIcon 2s infinite ease-in-out;
}

@keyframes floatIcon {
    0% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
    100% { transform: translateY(0); }
}

</style>
@endpush
