@extends('layouts.admin')

@section('title', 'Detalle de Reserva')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4"><i class="fas fa-eye"></i> Detalle de la Reserva</h1>

    <div class="row">

        {{-- Información del Alumno --}}
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>Datos del Alumno</strong>
                </div>
                <div class="card-body">
                    <p><strong>DNI:</strong> {{ $reserva->usuario->dni }}</p>
                    <p><strong>Nombre:</strong> {{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }}</p>
                    
                    <p><strong>Estado:</strong> {{ $reserva->usuario->estado }}</p>
                </div>
            </div>
        </div>

        {{-- Información del Libro --}}
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong>Datos del Libro</strong>
                </div>
                <div class="card-body">
                    <p><strong>Título:</strong> {{ $reserva->libroFisico->titulo }}</p>
                    <p><strong>Código:</strong> {{ $reserva->libroFisico->id_libro_fisico }}</p>
                    <p><strong>Ubicación:</strong> {{ $reserva->libroFisico->ubicacion_pasillo }}</p>
                    <p><strong>Categoría:</strong> {{ $reserva->libroFisico->categoria->nombre_categoria }}</p>
                    <p><strong>Stock Disponible:</strong> {{ $reserva->libroFisico->stock_disponible }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Información de la Reserva --}}
    <div class="card shadow-lg mb-3">
        <div class="card-header bg-dark text-white">
            <strong>Detalle de la Reserva</strong>
        </div>
        <div class="card-body">
            <p><strong>ID Reserva:</strong> {{ $reserva->id_reserva }}</p>
            <p><strong>Fecha Reserva:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</p>
            <p><strong>Fecha Límite de Recojo:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_limite_recojo)->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge bg-{{ $reserva->estado == 'ACTIVA' ? 'primary' : ($reserva->estado == 'EXPIRADA' ? 'danger' : 'success') }}">
                    {{ $reserva->estado }}
                </span>
            </p>
        </div>
    </div>

    {{-- Botón Volver --}}
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

</div>
<br>
<br>
@endsection
@push('styles')
<style>
    /* ==========================================================
   🔷 TITULO SUPER PREMIUM
========================================================== */
h1.mb-4 {
    font-weight: 900 !important;
    color: #033b47 !important;
    font-size: 2.2rem !important;
    letter-spacing: .8px;
    text-shadow: 
        0 2px 4px rgba(0, 0, 0, 0.15),
        0 0 12px rgba(135, 220, 255, 0.5);
    position: relative;
}

h1.mb-4::after {
    content: "";
    display: block;
    width: 140px;
    height: 4px;
    margin-top: 6px;
    background: linear-gradient(90deg, #33b6e5, #5de8c2);
    border-radius: 10px;
}

/* ==========================================================
   🔷 CARD VIP (Glass + Glow + Border)
========================================================== */
.card {
    border-radius: 1.9rem !important;
    background: rgba(255, 255, 255, 0.55) !important;
    backdrop-filter: blur(14px);
    border: 2px solid rgba(255,255,255,0.65);
    box-shadow:
        0 12px 30px rgba(0, 91, 128, 0.15),
        inset 0 0 18px rgba(255,255,255,0.35);
    transition: .25s ease-in-out;
    position: relative;
    overflow: hidden;
}

/* Cinta decorativa */
.card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 8px;
    height: 100%;
    background: linear-gradient(180deg, #68d2e8, #69eccd);
    box-shadow: 0 0 15px rgba(80,200,230,0.5);
}

/* Hover */
.card:hover {
    transform: translateY(-5px);
    box-shadow:
        0 20px 40px rgba(0, 91, 128, 0.22),
        inset 0 0 22px rgba(255,255,255,0.45);
}

/* ==========================================================
   🔷 HEADERS EXCLUSIVOS (EDICIÓN PREMIUM)
========================================================== */

.card-header {
    font-weight: 900 !important;
    font-size: 1.1rem;
    letter-spacing: .5px;
    padding: 1.2rem 1.6rem !important;
    border-radius: 1.9rem 1.9rem 0 0 !important;
    position: relative;
    color: #033b47 !important;
}

/* Decoración superior */
.card-header::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 15px;
    width: 60px;
    height: 4px;
    border-radius: 3px;
    background: #ffffff66;
}

/* Azul celeste */
.card-header.bg-primary {
    background: linear-gradient(135deg, #bdeFFF, #7ed4f3, #54bfe4) !important;
}

/* Verde agua */
.card-header.bg-success {
    background: linear-gradient(135deg, #d5ffe9, #96f2ce, #6adeb3) !important;
}

/* Azul petróleo elegante */
.card-header.bg-dark {
    background: linear-gradient(135deg, #8fb6c8, #5b8a9e, #396477) !important;
}

/* ==========================================================
   🔷 TEXTO INTERNO ELEGANTE
========================================================== */
.card-body p strong {
    color: #033b47 !important;
    font-weight: 900 !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.card-body p {
    font-size: 1.05rem;
    color: #05506b !important;
    margin-bottom: .6rem;
}

/* ==========================================================
   🔷 BADGES PREMIUM
========================================================== */
.badge {
    font-weight: 800 !important;
    padding: .5rem .9rem !important;
    border-radius: .9rem !important;
    box-shadow: 0 4px 11px rgba(0,0,0,0.12);
}

/* Azul */
.badge.bg-primary {
    background: #bdeFFF !important;
    color: #033b47 !important;
}

/* Roja */
.badge.bg-danger {
    background: #ffd6d6 !important;
    color: #962a2a !important;
}

/* Verde */
.badge.bg-success {
    background: #c6ffe8 !important;
    color: #046b3b !important;
}

/* ==========================================================
   🔷 BOTÓN VOLVER VIP
========================================================== */
.btn-secondary {
    border-radius: 1.1rem !important;
    background: linear-gradient(135deg, #e4f6fb, #d3ecf4, #c4e2ee) !important;
    color: #033b47 !important;
    padding: .75rem 1.7rem !important;
    font-weight: 800 !important;
    border: none !important;
    box-shadow: 0 8px 18px rgba(0, 91, 128, 0.18);
    transition: .28s;
}

.btn-secondary:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg, #d3ecf4, #bfe0ed) !important;
}

</style>
@endpush