@extends('layouts.admin')

@section('title', 'Libros Físicos')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book"></i> Libros Físicos</h1>

    <a href="{{ route('admin.libros_fisicos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Libro
    </a>

    <div class="card shadow-lg">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($libros as $libro)
                    <tr>
                        <td>{{ $libro->id_libro_fisico }}</td>
                        <td>{{ $libro->titulo }}</td>
                        <td>{{ $libro->autor }}</td>
                        <td>{{ $libro->categoria->nombre_categoria }}</td>
                        <td>{{ $libro->stock_disponible }}/{{ $libro->stock_total }}</td>
                        <td>{{ $libro->estado_promedio }}</td>
                        <td>
                            <a href="{{ route('admin.libros_fisicos.edit', $libro->id_libro_fisico) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.libros_fisicos.destroy', $libro->id_libro_fisico) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este libro?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
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

/* ==========================================
   🎨 TÍTULO
========================================== */
h1.mb-4 {
    color: #04445c !important;
    font-weight: 900 !important;
}

/* ==========================================
   🎨 CARD BASE – PASTEL MODERNO
========================================== */
.card {
    border-radius: 1.2rem !important;
    background: #ffffffee !important;
    border: 1px solid #c7e9f7 !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
}

/* ==========================================
   🎨 TABLA PASTEL CELESTE
========================================== */
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

/* Editar */
.btn-warning {
    background: #ffe8a8 !important;
    border-color: #ffe8a8 !important;
    color: #8a6c00 !important;
    border-radius: .8rem !important;
    font-weight: 600;
}

.btn-warning:hover {
    background: #ffd97a !important;
}

/* Eliminar */
.btn-danger {
    background: #ffd1d1 !important;
    border-color: #ffd1d1 !important;
    color: #a12424 !important;
    border-radius: .8rem !important;
    font-weight: 600;
}

.btn-danger:hover {
    background: #ffb3b3 !important;
}

/* ==========================================
   🎨 POSIBLE BADGE PARA ESTADO DEL LIBRO
   (Si luego cambias 'estado_promedio' a badge)
========================================== */
.badge-estado {
    padding: .45em .8em;
    border-radius: .8rem;
    font-weight: 600;
    font-size: 0.82rem;
}

.badge-bueno {
    background: #bef7d2 !important;
    color: #0b5e39 !important;
}

.badge-regular {
    background: #fff4c7 !important;
    color: #7a6000 !important;
}

.badge-malo {
    background: #ffd4d4 !important;
    color: #a12424 !important;
}

</style>
@endpush
