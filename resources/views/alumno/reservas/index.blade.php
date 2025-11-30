@extends('layouts.alumno')

@section('title', 'Historial de Reservas')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-calendar-check"></i> Mis Reservas</h1>

    <div class="card shadow-lg">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Fecha de Reserva</th>
                        <th>Fecha Límite de Recojo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->libroFisico->titulo ?? '-' }}</td>
                        <td>{{ $reserva->fecha_reserva }}</td>
                        <td>{{ $reserva->fecha_limite_recojo }}</td>
                        <td>
                            <span class="badge 
                                @if($reserva->estado == 'ACTIVA') bg-primary
                                @elseif($reserva->estado == 'EXPIRADA') bg-danger
                                @elseif($reserva->estado == 'COMPLETADA') bg-success
                                @endif">
                                {{ $reserva->estado }}
                            </span>
                        </td>

                        {{-- ACCIONES --}}
                        <td>
                            @if($reserva->estado == 'ACTIVA')
                                <form action="{{ route('alumno.reservas.destroy', $reserva->id_reserva) }}" 
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas cancelar esta reserva?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Cancelar
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

/* =======================================================
   🌟 TÍTULO
======================================================= */
h1 {
    font-weight: 900 !important;
    color: #033b47 !important;
    letter-spacing: .6px;
    text-shadow: 0 3px 8px rgba(0, 80, 110, 0.18);
}

/* =======================================================
   🌟 CARD ESTILO GLASS PREMIUM
======================================================= */
.card {
    border-radius: 18px !important;
    background: rgba(255,255,255,0.85) !important;
    backdrop-filter: blur(8px);
    border: 2px solid #c9f5ff !important;
    box-shadow: 0 12px 35px rgba(0, 120, 150, 0.12) !important;
    transition: .3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(0, 120, 150, 0.20) !important;
}

/* =======================================================
   🌟 TABLA PREMIUM
======================================================= */

/* Fondo general */
.table {
    border-radius: 12px !important;
    overflow: hidden;
}

/* Encabezado */
.table thead {
    background: linear-gradient(135deg, #c6f0ff, #aee6f7, #d8faff) !important;
    color: #033b47 !important;
    font-weight: 800;
    border-bottom: 2px solid #b6e8f7 !important;
}

/* Filas */
.table-striped > tbody > tr:nth-of-type(odd) {
    background: rgba(240, 250, 255, 0.9) !important;
}

.table-hover tbody tr:hover {
    background: rgba(210, 245, 255, 0.60) !important;
    transform: scale(1.002);
}

/* Bordes suaves */
.table td, .table th {
    border-color: #d4f0f7 !important;
}

/* =======================================================
   🌟 BADGES – ESTADOS
======================================================= */

/* ACTIVA */
.bg-primary {
    background: #70d4ff !important;
    color: #013b52 !important;
    font-weight: 800;
    padding: .45rem .7rem !important;
    border-radius: 10px;
}

/* EXPIRADA */
.bg-danger {
    background: #ffb7c7 !important;
    color: #7a0020 !important;
    font-weight: 800;
    border-radius: 10px;
}

/* COMPLETADA */
.bg-success {
    background: #b4f4d1 !important;
    color: #065535 !important;
    font-weight: 800;
    border-radius: 10px;
}

/* =======================================================
   ❌ BOTÓN CANCELAR
======================================================= */
.btn-danger.btn-sm {
    background: linear-gradient(135deg, #ffd8d8, #ffc3c3) !important;
    border: none !important;
    color: #8b1d1d !important;
    border-radius: 10px !important;
    font-weight: 700 !important;
    padding: .45rem .95rem !important;
    box-shadow: 0 5px 14px rgba(255, 120, 120, 0.25);
    transition: .2s ease;
}

.btn-danger.btn-sm:hover {
    background: linear-gradient(135deg, #ffb3b3, #ffa5a5) !important;
    transform: translateY(-2px);
}

/* =======================================================
   🌫️ TEXTO DESHABILITADO
======================================================= */
.text-muted {
    color: #7b8a92 !important;
}

/* =======================================================
   📱 RESPONSIVE (MEJORA VISUAL MOBILE)
======================================================= */
@media (max-width: 768px) {
    .table td, .table th {
        padding: .75rem .5rem !important;
    }
}

</style>
@endpush
