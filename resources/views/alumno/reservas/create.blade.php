@extends('layouts.alumno')

@section('title', 'Reservar Libro')

@section('content')
<div class="container">
    <h3>Reservar Libro</h3>

    {{-- MENSAJE SI YA RESERVÓ EL LIBRO --}}
    @if (session('info'))
        <div class="alert alert-warning">
            {{ session('info') }}
        </div>
    @endif

    <div class="card p-4 shadow">
        <h4>{{ $libro->titulo }}</h4>
        <p>Autor: {{ $libro->autor }}</p>
        <p>Stock disponible: {{ $libro->stock_disponible }}</p>

        <form action="{{ route('alumno.reservas.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_libro_fisico" value="{{ $libro->id_libro_fisico }}">

            <div class="alert alert-info">
                📅 *Recuerda:* Tienes **1días** para recoger tu libro en biblioteca.
            </div>

            <button class="btn btn-success btn-lg">Confirmar Reserva</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>

/* ============================================================
   🌟 TÍTULO PRINCIPAL
============================================================ */
h3 {
    font-weight: 900;
    color: #033b47;
    letter-spacing: .6px;
    margin-bottom: 1.2rem;
    text-shadow: 0 3px 8px rgba(0,90,110,0.20);
}

/* ============================================================
   📘 TARJETA PRINCIPAL — GLASSMORPHISM TURQUESA
============================================================ */
.card {
    border-radius: 20px !important;
    background: rgba(255,255,255,0.85) !important;
    backdrop-filter: blur(6px);
    border: 2px solid #c8f5ff !important;
    box-shadow: 0 10px 28px rgba(0,120,150,0.12) !important;
    transition: .3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,120,150,0.20) !important;
}

/* ============================================================
   📗 TÍTULO DEL LIBRO
============================================================ */
.card h4 {
    font-size: 1.5rem;
    font-weight: 800 !important;
    color: #023b4b !important;
    margin-bottom: 1rem;
}

/* ============================================================
   📘 TEXTO DEL LIBRO
============================================================ */
.card p {
    font-size: .98rem;
    font-weight: 600;
    color: #055064 !important;
}

/* ============================================================
   ℹ️ ALERTAS PERSONALIZADAS
============================================================ */
.alert-info {
    background: #d4f6ff !important;
    color: #06485a !important;
    border: none !important;
    border-radius: 14px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0,140,170,0.15);
}

.alert-warning {
    background: #fff2c5 !important;
    color: #7a6200 !important;
    border-radius: 14px;
    border: none !important;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(180,150,0,0.15);
}

/* ============================================================
   🟢 BOTÓN CONFIRMAR RESERVA (TURQUESA PREMIUM)
============================================================ */
.btn-success {
    background: linear-gradient(135deg, #75e7cf, #47cfae) !important;
    border: none !important;
    color: #033e33 !important;
    font-weight: 800 !important;
    border-radius: 14px !important;
    padding: .75rem 1.6rem !important;
    box-shadow: 0 8px 20px rgba(40,160,140,0.25);
    transition: .25s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #47cfae, #34b593) !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(30,150,130,0.35);
}

/* ============================================================
   📘 CONTENEDOR GENERAL
============================================================ */
.container {
    max-width: 900px;
}

</style>
@endpush
