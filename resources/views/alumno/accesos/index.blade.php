@extends('layouts.alumno')

@section('title', 'Mis Accesos Virtuales')

@section('content')
<div class="container py-3">

    <h2 class="mb-4">
        <i class="fas fa-laptop me-2"></i> Mis Accesos Virtuales
    </h2>

    {{-- MENSAJES DE ALERTA --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- SI NO HAY ACCESOS --}}
    @if ($accesos->count() == 0)
        <div class="alert alert-info">
            No tienes accesos virtuales generados aún.
        </div>
    @endif

    <div class="row g-3">
        @foreach ($accesos as $acceso)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">

                        {{-- TÍTULO DEL LIBRO --}}
                        <h5 class="fw-bold mb-1">
                            {{ $acceso->libroVirtual->titulo ?? 'Título no disponible' }}
                        </h5>

                        {{-- AUTOR --}}
                        <p class="text-muted mb-2">
                            <i class="fas fa-user me-1"></i>
                            {{ $acceso->libroVirtual->autor ?? 'Autor no disponible' }}
                        </p>

                        {{-- FECHA DE GENERACIÓN --}}
                        <p class="small mb-1">
                            <i class="fas fa-calendar me-2 text-primary"></i>
                            Generado: {{ \Carbon\Carbon::parse($acceso->fecha_generacion)->format('d/m/Y H:i') }}
                        </p>

                        {{-- FECHA DE CADUCIDAD --}}
                        <p class="small mb-3">
                            <i class="fas fa-clock me-2 text-danger"></i>
                            Expira: {{ \Carbon\Carbon::parse($acceso->fecha_caducidad)->format('d/m/Y H:i') }}
                        </p>

                        {{-- ESTADO --}}
                        <p class="mb-3">
                            @if($acceso->estado === 'ACTIVO')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Caducado</span>
                            @endif
                        </p>

                        {{-- ACCIONES --}}
                        <div class="d-flex gap-2">

                            {{-- LEER --}}
                            @if($acceso->estado === 'ACTIVO')
                                <a href="{{ route('alumno.accesos.pdf', $acceso->token_seguridad) }}"
                                   target="_blank"
                                   class="btn btn-primary flex-grow-1">
                                   <i class="fas fa-file-pdf me-2"></i> Leer
                                </a>
                            @else
                                <button class="btn btn-secondary flex-grow-1" disabled>
                                    <i class="fas fa-ban me-2"></i> Caducado
                                </button>
                            @endif

                            {{-- ELIMINAR --}}
                            <form action="{{ route('alumno.accesos.destroy', $acceso->id_acceso) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este acceso?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection

@push('styles')
<style>

/* ==========================================
   🎨 TÍTULO PRINCIPAL
========================================== */
h2.mb-4 {
    font-weight: 900 !important;
    color: #04445c !important;
    letter-spacing: .5px;
}

/* ==========================================
   🎨 CARD BASE – ESTILO PASTEL
========================================== */
.card {
    border-radius: 1.2rem !important;
    background: #ffffffee !important;
    border: 1px solid #c7e9f7 !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    transition: transform .2s ease, box-shadow .2s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 35px rgba(0,0,0,0.12) !important;
}

/* ==========================================
   🎨 TEXTO DEL LIBRO
========================================== */
.card-body h5 {
    color: #05546a !important;
    font-weight: 800 !important;
}

.text-muted {
    color: #5c7280 !important;
}

/* ==========================================
   🎨 BADGES ESTADOS
========================================== */
.badge {
    font-size: .78rem !important;
    font-weight: 700 !important;
    padding: .45em .7em !important;
    border-radius: .6rem !important;
}

.bg-success {
    background: #c8ffe0 !important;
    color: #075c36 !important;
}

.bg-danger {
    background: #ffd4d4 !important;
    color: #8a1f1f !important;
}

/* ==========================================
   🎨 BOTONES
========================================== */

/* Leer (activo) */
.btn-primary {
    background: #6dccff !important;
    border-color: #6dccff !important;
    color: #003f5a !important;
    font-weight: 600 !important;
    border-radius: .8rem !important;
}
.btn-primary:hover {
    background: #55c0ff !important;
}

/* Caducado */
.btn-secondary {
    background: #e0e7eb !important;
    border-color: #e0e7eb !important;
    color: #55656f !important;
    border-radius: .8rem !important;
    font-weight: 600 !important;
}

/* Eliminar */
.btn-danger {
    background: #ffd1d1 !important;
    border-color: #ffd1d1 !important;
    color: #8b1d1d !important;
    border-radius: .8rem !important;
    font-weight: 600;
}
.btn-danger:hover {
    background: #ffb3b3 !important;
}

/* ==========================================
   🎨 ALERTAS SUAVES
========================================== */
.alert-success {
    background: #d5f5e7 !important;
    border-color: #c1f0db !important;
    color: #0b5d3b !important;
    border-radius: .8rem !important;
}

.alert-danger {
    background: #ffe2e2 !important;
    border-color: #ffc9c9 !important;
    color: #8b1d1d !important;
    border-radius: .8rem !important;
}

.alert-info {
    background: #d9f2ff !important;
    border-color: #c3eaff !important;
    color: #04445c !important;
    border-radius: .8rem !important;
}

/* ==========================================
   🎨 GRID AJUSTADO
========================================== */
.container {
    max-width: 1100px;
}

</style>
@endpush
