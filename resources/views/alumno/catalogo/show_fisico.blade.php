@extends('layouts.alumno')

@section('title', 'Detalles del Libro Físico')

@section('content')
<div class="container mt-4">

    {{-- 🔥 BOTÓN RESERVAR / MENSAJE DE RESERVA ACTIVA --}}
    @if ($libro->stock_disponible > 0)
        @if($yaTieneReserva)
            <button class="btn btn-warning w-100 mb-3"
                onclick="alert('Ya tienes una reserva activa. Solo puedes tener una a la vez.')">
                <i class="fas fa-info-circle"></i> Ya tienes una reserva activa
            </button>
        @else
            <a href="{{ route('alumno.reservas.create', $libro->id_libro_fisico) }}" 
               class="btn btn-primary w-100 mb-3">
                <i class="fas fa-calendar-plus"></i> Reservar Libro
            </a>
        @endif
    @else
        <div class="alert alert-danger w-100 mb-3 text-center">
            No hay ejemplares disponibles.
        </div>
    @endif


    <div class="card shadow-lg border-0">
        
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-book"></i> {{ $libro->titulo }}
            </h4>
        </div>

        <div class="card-body row">

            {{-- Imagen --}}
            <div class="col-md-4 text-center">
                <img src="{{ $libro->imagen_portada 
                    ? asset('storage/' . $libro->imagen_portada) 
                    : asset('img/no-image.png') }}"
                    class="img-fluid rounded shadow"
                    style="max-height: 350px;">
            </div>

            {{-- Información --}}
            <div class="col-md-8">

                <h5 class="mb-3">Información del Libro</h5>

                <p><strong>Autor:</strong> {{ $libro->autor }}</p>
                <p><strong>Categoría:</strong> {{ $libro->categoria->nombre }}</p>
                <p><strong>ISBN:</strong> {{ $libro->isbn ?? 'No registrado' }}</p>
                <p><strong>Editorial:</strong> {{ $libro->editorial ?? 'No registrado' }}</p>
                <p><strong>Año edición:</strong> {{ $libro->año_edicion ?? 'Sin año' }}</p>

                <p><strong>Encuadernación:</strong> {{ $libro->tipo_encuadernacion }}</p>
                <p><strong>Condición:</strong> {{ $libro->estado_promedio }}</p>

                <p><strong>Disponibles:</strong> 
                    <span class="badge bg-success">{{ $libro->stock_disponible }}</span>
                </p>

                <p><strong>Ubicación:</strong> {{ $libro->ubicacion_pasillo ?? 'No especificado' }}</p>

            </div>

        </div>
    </div>

</div>
@endsection

@push('styles')
<style>

/* ============================================================
   🎨 BOTONES PRINCIPALES (Reservar / Ya tiene reserva)
============================================================ */
.btn-primary {
    background: linear-gradient(135deg, #7ddfff, #4cc7e0) !important;
    border: none !important;
    color: #033b47 !important;
    font-weight: 700 !important;
    border-radius: 12px !important;
    padding: .8rem !important;
    box-shadow: 0 6px 15px rgba(0,140,170,0.18);
    transition: .25s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #55c8e2, #37b7cf) !important;
    transform: translateY(-2px);
}

.btn-warning {
    background: #fff0c4 !important;
    border: none !important;
    color: #7a5c00 !important;
    font-weight: 700 !important;
    border-radius: 12px !important;
    padding: .8rem !important;
    box-shadow: 0 6px 15px rgba(190,150,0,0.18);
}

/* ============================================================
   ❗ ALERTA SIN STOCK
============================================================ */
.alert-danger {
    border-radius: 12px !important;
    background: #ffe1e1 !important;
    color: #9b2d2d !important;
    font-weight: 700;
    box-shadow: 0 6px 18px rgba(200,0,0,0.15);
}

/* ============================================================
   📘 TARJETA PRINCIPAL — GLASS PREMIUM
============================================================ */
.card {
    border-radius: 20px !important;
    background: rgba(255,255,255,0.85) !important;
    backdrop-filter: blur(8px);
    border: 2px solid #c8f5ff !important;
    overflow: hidden;
    box-shadow: 0 12px 35px rgba(0, 110, 130, 0.12) !important;
    animation: fadeCard .5s ease;
}

@keyframes fadeCard {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ============================================================
   📘 CABECERA — GRADIENTE CELESTE–TURQUESA
============================================================ */
.card-header {
    background: linear-gradient(135deg, #7de3e0, #6bcdf0, #b3ecff) !important;
    color: #033b47 !important;
    font-weight: 900 !important;
    letter-spacing: .5px;
    border-radius: 20px 20px 0 0 !important;
    padding: 1.1rem 1.4rem !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.20);
}

/* ============================================================
   ✏ TIPOGRAFÍA Y TEXTOS
============================================================ */
h4 {
    font-weight: 900 !important;
    letter-spacing: .4px;
}

h5 {
    color: #04445c !important;
    font-weight: 800 !important;
    margin-top: 8px;
}

p {
    color: #033b47 !important;
    font-size: .97rem;
    margin-bottom: .45rem;
}

p strong {
    color: #022f3b !important;
}

/* Línea separadora suave */
hr {
    background: #d9f5ff;
    height: 1px;
    border: none;
}

/* ============================================================
   📘 IMAGEN DEL LIBRO — SOMBRA & HOVER
============================================================ */
.img-fluid {
    border-radius: 14px !important;
    padding: 4px;
    background: #effbff;
    border: 2px solid #c7f3fa;
    box-shadow: 0 10px 26px rgba(0,100,120,0.15);
    transition: .3s ease;
}

.img-fluid:hover {
    transform: scale(1.04);
    box-shadow: 0 14px 32px rgba(0,130,160,0.22);
}

/* ============================================================
   🟩 BADGE DE STOCK
============================================================ */
.badge.bg-success {
    background: #9af2d7 !important;
    color: #064f3c !important;
    font-weight: 800 !important;
    border-radius: 10px !important;
    padding: .5em .8em !important;
    font-size: .9rem;
    box-shadow: 0 4px 10px rgba(0,120,90,0.15);
}

/* ============================================================
   📏 CONTENEDOR GENERAL
============================================================ */
.container {
    max-width: 1050px !important;
}

</style>
@endpush
