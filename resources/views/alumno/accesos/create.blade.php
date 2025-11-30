@extends('layouts.alumno')

@section('title', 'Generar Acceso Virtual')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h3 class="fw-bold mb-2">
                <i class="fas fa-file-pdf me-2"></i> Generar acceso virtual
            </h3>

            <p class="text-muted">
                Estás por generar un acceso de 7 días para el libro:
            </p>

            <div class="p-3 bg-light rounded mb-3">
                <h5 class="mb-1">{{ $libro->titulo }}</h5>
                <p class="mb-0">
                    <i class="fas fa-user me-2"></i>{{ $libro->autor }}
                </p>
            </div>

            <form action="{{ route('alumno.accesos.store') }}" method="POST">
                @csrf

                <input type="hidden" name="id_libro_virtual" value="{{ $libro->id_libro_virtual }}">

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Este acceso será válido por <strong>7 días</strong> y no podrá regenerarse hasta que expire.
                </div>

                <button class="btn btn-success w-100">
                    <i class="fas fa-check me-2"></i>
                    Confirmar y generar acceso
                </button>

            </form>

        </div>
    </div>

</div>
@endsection

@push('styles')
<style>

/* ============================================================
   🎨 TÍTULO PRINCIPAL
============================================================ */
h3 {
    font-weight: 900;
    color: #033b47;
    letter-spacing: .6px;
    text-shadow: 0 2px 6px rgba(0, 70, 90, 0.18);
    margin-bottom: 1.1rem;
}

/* ============================================================
   🎨 CARD PRINCIPAL – GLASS PREMIUM
============================================================ */
.card {
    border-radius: 20px !important;
    background: rgba(255, 255, 255, 0.85) !important;
    backdrop-filter: blur(8px);
    border: 2px solid #c8f5ff !important;
    box-shadow: 0 12px 35px rgba(0, 120, 150, 0.12) !important;
    transition: .3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 45px rgba(0, 120, 150, 0.20) !important;
}

/* ============================================================
   📝 DESCRIPCIÓN DEL LIBRO
============================================================ */
.bg-light {
    background: #e9faff !important;
    border: 2px solid #c8f7ff !important;
    border-radius: 14px !important;
}

.bg-light h5 {
    color: #033b47 !important;
    font-weight: 800 !important;
}

.bg-light p {
    color: #055064 !important;
    font-weight: 600;
}

/* ============================================================
   ⚠️ ALERTA PERSONALIZADA
============================================================ */
.alert-warning {
    background: #fff4d1 !important;
    border-radius: 12px !important;
    color: #7a5c00 !important;
    font-weight: 700 !important;
    border: none !important;
    box-shadow: 0 6px 14px rgba(190,150,0,0.18);
}

/* ============================================================
   ✔️ BOTÓN CONFIRMAR
============================================================ */
.btn-success {
    background: linear-gradient(135deg, #79e6cf, #43c9ab) !important;
    border: none !important;
    color: #023b32 !important;
    font-weight: 800 !important;
    padding: .9rem !important;
    border-radius: 14px !important;
    box-shadow: 0 10px 25px rgba(40,150,130,0.25);
    transition: .25s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #4dd4b3, #2fb89a) !important;
    transform: translateY(-3px);
    box-shadow: 0 14px 32px rgba(40,150,130,0.35);
}

/* ============================================================
   ✨ TEXTOS GENERALES
============================================================ */
.text-muted {
    color: #055064 !important;
    font-size: .95rem;
}

</style>
@endpush
