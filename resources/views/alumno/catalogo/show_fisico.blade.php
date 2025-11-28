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

/* ==========================================
   🎨 TÍTULO / BOTONES
========================================== */
.btn-primary {
    background: #6dcfff !important;
    border-color: #6dcfff !important;
    color: #003f5a !important;
    border-radius: .9rem !important;
    font-weight: 600 !important;
}
.btn-primary:hover { background: #55c6ff !important; }

.btn-warning {
    background: #ffe6a3 !important;
    border-color: #ffe6a3 !important;
    color: #7a5c00 !important;
    border-radius: .9rem !important;
    font-weight: 600 !important;
}

.alert-danger {
    border-radius: .8rem !important;
    background: #ffd4d4 !important;
    color: #8b1d1d !important;
    border: none !important;
    font-weight: 600;
}

/* ==========================================
   🎨 TARJETA PRINCIPAL
========================================== */
.card {
    border-radius: 1.3rem !important;
    background: #ffffffee !important;
    border: 1px solid #c8ecf7 !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.09) !important;
}

.card-header {
    border-radius: 1.3rem 1.3rem 0 0 !important;
    background: linear-gradient(135deg, #8fe8ff, #6dd5ff) !important;
    color: #023b4b !important;
    font-weight: 800 !important;
    letter-spacing: .5px;
}

/* ==========================================
   🎨 TÍTULOS Y TEXTO
========================================== */
h4 {
    font-weight: 800 !important;
    color: #023b4b !important;
}

h5 {
    font-weight: 700 !important;
    color: #04445c !important;
}

p strong {
    color: #023b4b !important;
}

/* ==========================================
   🎨 IMAGEN DEL LIBRO
========================================== */
.img-fluid {
    border-radius: 1rem !important;
    box-shadow: 0 6px 20px rgba(0,0,0,.12) !important;
}

/* ==========================================
   🎨 BADGES
========================================== */
.badge.bg-success {
    background: #bfffe5 !important;
    color: #076842 !important;
    padding: .45em .75em;
    font-size: .85rem;
    border-radius: .7rem !important;
    font-weight: 700 !important;
}

/* ==========================================
   🎨 CONTENEDOR
========================================== */
.container {
    max-width: 1050px;
}

</style>
@endpush
