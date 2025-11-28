@extends('layouts.alumno')

@section('title', 'Dashboard Alumno')

@section('content')
<div class="container-fluid">
    {{-- HERO / BIENVENIDA --}}
    <div class="mb-4">
        <div class="card border-0 shadow-lg alumno-hero-card">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="alumno-hero-title mb-2">
                        Hola, {{ auth()->user()->nombres ?? 'Alumno' }} 👋
                    </h1>
                    <p class="alumno-hero-subtitle mb-0">
                        Revisa tus <strong>reservas activas</strong> y tus <strong>accesos virtuales</strong> de la Biblioteca Virtual.
                    </p>
                </div>
                <div class="alumno-hero-pill text-nowrap">
                    <i class="fas fa-calendar-day me-2"></i>
                    <span>{{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- TARJETAS ESTADÍSTICAS --}}
    <div class="row g-3">
        {{-- Reservas Activas --}}
        <div class="col-md-6">
            <div class="card alumno-stat-card shadow-lg border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="alumno-stat-label mb-1">
                            <i class="fas fa-calendar-check me-2 text-primary"></i>
                            Reservas activas
                        </p>
                        <h3 class="alumno-stat-value mb-0">{{ $reservasActivas }}</h3>
                    </div>
                    <div class="alumno-stat-icon alumno-stat-icon-primary">
                        <i class="fas fa-bookmark"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('alumno.reservas.index') }}" class="alumno-link">
                        Ver mis reservas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Accesos Virtuales --}}
        <div class="col-md-6">
            <div class="card alumno-stat-card shadow-lg border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="alumno-stat-label mb-1">
                            <i class="fas fa-file-pdf me-2 text-success"></i>
                            Accesos virtuales
                        </p>
                        <h3 class="alumno-stat-value mb-0">{{ $accesosVirtuales }}</h3>
                    </div>
                    <div class="alumno-stat-icon alumno-stat-icon-success">
                        <i class="fas fa-laptop"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('alumno.accesos.index') }}" class="alumno-link">
                        Ver materiales virtuales <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>

/* =============================
   🎨 HERO – Encabezado
============================= */
.alumno-hero-card {
    background: linear-gradient(135deg, #b3ecff, #7de3e0, #e6dbff);
    border-radius: 22px;
    padding: 1rem;
    box-shadow: 0 10px 28px rgba(0,0,0,0.12);
    border: 2px solid #a8f2df;
    animation: heroGlow 6s infinite alternate ease-in-out;
}

@keyframes heroGlow {
    0% { box-shadow: 0 10px 25px rgba(125, 227, 224, 0.45); }
    100% { box-shadow: 0 12px 40px rgba(179, 236, 255, 0.65); }
}

.alumno-hero-title {
    font-size: 1.9rem;
    font-weight: 900;
    color: #064663;
}

.alumno-hero-subtitle {
    font-size: 1.05rem;
    color: #033843;
    font-weight: 500;
}

.alumno-hero-pill {
    background: #064663cc;
    color: #eaffff;
    border: 2px solid #7de3e0;
    font-size: .9rem;
    padding: .55rem 1.1rem;
    border-radius: 999px;
}


/* =============================
   🎨 TARJETAS DE ESTADÍSTICA
============================= */
.alumno-stat-card {
    border-radius: 20px !important;
    background: linear-gradient(135deg, #ffffff, #f0fdff);
    border: 2px solid #c6f7ef;
    box-shadow: 0 10px 22px rgba(0,0,0,0.08) !important;
    transition: .3s ease;
}

.alumno-stat-card:hover {
    transform: translateY(-7px) scale(1.02);
    box-shadow: 0 16px 35px rgba(0,0,0,0.15) !important;
    background: linear-gradient(135deg, #e6faff, #b3ecff, #dffaff);
}

.alumno-stat-label {
    font-size: 1rem;
    color: #064663cc;
    font-weight: 600;
}

.alumno-stat-value {
    font-size: 2.5rem;
    font-weight: 900;
    color: #032d33;
}


/* =============================
   🎨 ICONOS DE LAS TARJETAS
============================= */
.alumno-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    box-shadow: 0 14px 30px rgba(0,0,0,0.18);
    color: white;
    text-shadow: 0 3px 8px rgba(0,0,0,0.25);
}

.alumno-stat-icon-primary {
    background: linear-gradient(135deg, #7de3e0, #5dcad6);
}

.alumno-stat-icon-success {
    background: linear-gradient(135deg, #a8f2df, #5dd8bb);
}


/* =============================
   🎨 ENLACES
============================= */
.alumno-link {
    font-size: .95rem;
    font-weight: 700;
    color: #066b7a !important;
    text-decoration: none !important;
    transition: .25s ease;
}

.alumno-link:hover {
    color: #034f58 !important;
    text-decoration: underline !important;
}


/* =============================
   ✨ RESPONSIVE
============================= */
@media (max-width: 768px) {
    .alumno-hero-title {
        font-size: 1.5rem;
    }
    .alumno-stat-value {
        font-size: 2rem;
    }
}

</style>
@endpush
