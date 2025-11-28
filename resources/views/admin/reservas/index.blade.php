@extends('layouts.admin')
@section('title','Reservas')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Reservas</h1>

    {{-- Mensajes de sesión --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary mb-3">Nueva reserva</a>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Libro</th>
                        <th>Fecha reserva</th>
                        <th>Fecha límite</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $r)
                    <tr>
                        <td>{{ $r->id_reserva }}</td>
                        <td>{{ $r->usuario->nombres ?? $r->dni_usuario }} {{ $r->usuario->apellidos ?? '' }}</td>
                        <td>{{ $r->libroFisico->titulo ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->fecha_reserva)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->fecha_limite_recojo)->format('Y-m-d') }}</td>
                        <td>
                            @if($r->estado === 'ACTIVA')
                                <span class="badge bg-success">Activa</span>
                            @elseif($r->estado === 'COMPLETADA')
                                <span class="badge bg-primary">Completada</span>
                            @elseif($r->estado === 'EXPIRADA')
                                <span class="badge bg-warning">Expirada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.reservas.show', $r->id_reserva) }}" class="btn btn-info btn-sm mb-1">Ver</a>

                            @if($r->estado === 'ACTIVA')
                                {{-- Convertir en préstamo --}}
                                <form action="{{ route('admin.reservas.convertirPrestamo', $r->id_reserva) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm mb-1">Convertir en préstamo</button>
                                </form>

                                {{-- Expirar reserva --}}
                                <form action="{{ route('admin.reservas.expirar', $r->id_reserva) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm mb-1">Expirar</button>
                                </form>
                            @endif

                            {{-- Eliminar reserva --}}
                            <form action="{{ route('admin.reservas.destroy', $r->id_reserva) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mb-1"
                                    onclick="return confirm('¿Seguro que deseas eliminar esta reserva?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay reservas registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $reservas->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

/* ===============================
   🟦 CARD PASTEL
================================ */
.card {
    border-radius: 1.3rem !important;
    background: #ffffffee !important;
    border: 1px solid #c7e9f7 !important;
    box-shadow: 0 6px 14px rgba(0,0,0,0.08) !important;
}

/* ===============================
   🟦 TABLA ESTILO TURQUESA
================================ */
.table thead.table-dark {
    background: #94d9e5 !important;
    color: #03414b !important;
}

.table tbody tr:hover {
    background: #e8fcff !important;
    transition: .2s ease;
}

/* Columnas */
.table td, .table th {
    border-color: #bde9f1 !important;
}

/* ===============================
   🟦 BADGES PASTELES
================================ */
.badge.bg-success {
    background-color: #b6f5d5 !important;
    color: #0c7140 !important;
}

.badge.bg-primary {
    background-color: #a4d2ff !important;
    color: #00427a !important;
}

.badge.bg-warning {
    background-color: #ffe5a3 !important;
    color: #8a6c00 !important;
}

/* ===============================
   🟦 BOTONES SUAVES
================================ */
.btn-primary {
    background: #4cb8ff !important;
    border-color: #4cb8ff !important;
    color: #003750 !important;
}

.btn-primary:hover {
    background: #34a4ee !important;
}

.btn-info {
    background: #9ae7ff !important;
    border-color: #9ae7ff !important;
    color: #03445c !important;
}

.btn-success {
    background: #a9f3c7 !important;
    border-color: #a9f3c7 !important;
    color: #0b613a !important;
}

.btn-warning {
    background: #ffe3a1 !important;
    border-color: #ffe3a1 !important;
    color: #7a5a00 !important;
}

.btn-danger {
    background: #ffd1d1 !important;
    border-color: #ffd1d1 !important;
    color: #a12424 !important;
}

/* Bordes redondeados en botones */
.btn {
    border-radius: .8rem !important;
    font-weight: 600 !important;
}

/* ===============================
   🟦 TÍTULO
================================ */
h1.mb-4 {
    color: #03445c !important;
    font-weight: 800 !important;
}

</style>
@endpush
