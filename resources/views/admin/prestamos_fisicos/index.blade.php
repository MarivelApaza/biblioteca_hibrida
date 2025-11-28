@extends('layouts.admin')

@section('title', 'Préstamos Físicos')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book-reader"></i> Préstamos Físicos</h1>

    {{-- Filtros --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.prestamos_fisicos.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="estado" class="form-label"><strong>Filtrar por estado:</strong></label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="PENDIENTE" {{ request('estado')=='PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                        <option value="DEVUELTO" {{ request('estado')=='DEVUELTO' ? 'selected' : '' }}>Devuelto</option>
                        <option value="MORA" {{ request('estado')=='MORA' ? 'selected' : '' }}>Mora</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-md-6 text-end d-flex justify-content-end align-items-end">
                    <a href="{{ route('admin.prestamos_fisicos.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Préstamo
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de préstamos --}}
    <div class="card shadow-lg">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Libro</th>
                        <th>Fecha Salida</th>
                        <th>Fecha Devolución Programada</th>
                        <th>Fecha Devolución Real</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos as $prestamo)
                    <tr>
                        <td>{{ $prestamo->id_prestamo }}</td>
                        <td>{{ $prestamo->usuario->nombres }} {{ $prestamo->usuario->apellidos }}</td>
                        <td>{{ $prestamo->libroFisico->titulo }}</td>
                        <td>{{ $prestamo->fecha_salida->format('d/m/Y H:i') }}</td>
                        <td>{{ $prestamo->fecha_devolucion_programada->format('d/m/Y') }}</td>
                        <td>{{ $prestamo->fecha_devolucion_real ? $prestamo->fecha_devolucion_real->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @if($prestamo->estado == 'PENDIENTE')
                                <span class="badge bg-warning">Pendiente</span>
                            @elseif($prestamo->estado == 'DEVUELTO')
                                <span class="badge bg-success">Devuelto</span>
                            @else
                                <span class="badge bg-danger">Mora</span>
                            @endif
                        </td>
                        <td>{{ $prestamo->observaciones_devolucion ?? '-' }}</td>
                        <td>
                            @if($prestamo->estado == 'PENDIENTE')
                                {{-- Redirige al formulario de devolución --}}
                                <a href="{{ route('admin.prestamos_fisicos.devolverForm', $prestamo->id_prestamo) }}" 
                                   class="btn btn-sm btn-success mb-1">
                                    <i class="fas fa-check"></i> Marcar Devuelto
                                </a>
                                <a href="{{ route('admin.prestamos_fisicos.edit', $prestamo->id_prestamo) }}" 
                                   class="btn btn-sm btn-secondary mb-1">
                                    <i class="fas fa-comment-dots"></i> Agregar Observación
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No hay préstamos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $prestamos->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

/* ==========================================
   🎨 TITULO PRINCIPAL
========================================== */
h1.mb-4 {
    color: #04445c !important;
    font-weight: 900 !important;
}

/* ==========================================
   🎨 CARD BASE – ESTILO PASTEL
========================================== */
.card {
    border-radius: 1.2rem !important;
    background: #ffffffea !important;
    border: 1px solid #c7e9f7 !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
}

/* ==========================================
   🎨 FORMULARIO DE FILTROS
========================================== */
.form-select, .form-control {
    border-radius: .8rem !important;
    border-color: #b6e7f5 !important;
}

.form-select:focus, .form-control:focus {
    background: #f1fbff !important;
    border-color: #5bccf3 !important;
    box-shadow: 0 0 0 .2rem rgba(0,170,255,.3) !important;
}

/* ==========================================
   🎨 BOTONES PASTEL
========================================== */
.btn-primary {
    background: #6dccff !important;
    border-color: #6dccff !important;
    color: #003f5a !important;
    border-radius: .8rem !important;
    font-weight: 600 !important;
}

.btn-primary:hover {
    background: #55c0ff !important;
}

.btn-success {
    background: #9ff0c5 !important;
    border-color: #9ff0c5 !important;
    color: #0c5e39 !important;
    border-radius: .8rem !important;
    font-weight: 600;
}

.btn-success:hover {
    background: #80eab3 !important;
}

.btn-secondary {
    background: #d8edff !important;
    border-color: #d8edff !important;
    color: #004675 !important;
    border-radius: .8rem !important;
    font-weight: 600;
}

.btn-secondary:hover {
    background: #c0e0ff !important;
}

/* ==========================================
   🎨 TABLA PASTEL CELESTE–TURQUESA
========================================== */
.table thead.table-dark {
    background: #c8f0ff !important;
    color: #04445c !important;
    border-bottom: 2px solid #b6e8f7 !important;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background: #f4fcff !important;
}

.table-hover tbody tr:hover {
    background: #e6fbff !important;
}

.table td, .table th {
    border-color: #cdeaf3 !important;
}

/* ==========================================
   🎨 BADGES PASTELES
========================================== */
.badge.bg-warning {
    background: #ffe7a4 !important;
    color: #8a6b00 !important;
}

.badge.bg-success {
    background: #c6fbdc !important;
    color: #0c6239 !important;
}

.badge.bg-danger {
    background: #ffd1d1 !important;
    color: #a01e1e !important;
}

/* ==========================================
   🎨 PAGINACIÓN PASTEL
========================================== */
.page-link {
    border-radius: .5rem !important;
    border: none !important;
    color: #03516a !important;
    background: #e6faff !important;
}

.page-item.active .page-link {
    background: #7ad8ff !important;
    color: #033b47 !important;
}

</style>
@endpush
