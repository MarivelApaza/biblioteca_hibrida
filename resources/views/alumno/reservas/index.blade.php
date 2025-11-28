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

/* ===============================
   🎨 TÍTULO
================================ */
h1 {
    font-weight: 900 !important;
    color: #04445c !important;
}

/* ===============================
   🎨 CARD PASTEL
================================ */
.card {
    border-radius: 1.2rem !important;
    background: #ffffffee !important;
    border: 1px solid #c7e9f7 !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08) !important;
}

/* ===============================
   🎨 TABLA PASTEL CELESTE
================================ */
.table thead {
    background: #c8f0ff !important;
    color: #04445c !important;
    border-bottom: 2px solid #b6e8f7 !important;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background: #f4fcff !important;
}

.table-hover tbody tr:hover {
    background: #e8fbff !important;
    transition: .2s ease;
}

.table td, .table th {
    border-color: #cdeaf3 !important;
    vertical-align: middle !important;
}

/* ===============================
   🎨 BADGES – ESTADOS
================================ */
.bg-primary {
    background: #6dccff !important;
    color: #003f5a !important;
}

.bg-danger {
    background: #ffb3c7 !important;
    color: #7a001c !important;
}

.bg-success {
    background: #c6f5d4 !important;
    color: #0b5e39 !important;
}

/* ===============================
   🎨 BOTÓN CANCELAR
================================ */
.btn-danger.btn-sm {
    background: #ffd1d1 !important;
    border-color: #ffd1d1 !important;
    color: #a12424 !important;
    border-radius: .7rem !important;
    font-weight: 600;
    padding: .35rem .8rem !important;
}

.btn-danger.btn-sm:hover {
    background: #ffb3b3 !important;
}

/* ===============================
   🎨 TEXTO DESHABILITADO
================================ */
.text-muted {
    color: #7b8a92 !important;
}

</style>
@endpush
