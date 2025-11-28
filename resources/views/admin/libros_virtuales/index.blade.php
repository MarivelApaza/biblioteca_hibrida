@extends('layouts.admin')

@section('title', 'Libros Virtuales')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-book-open"></i> Libros Virtuales</h1>

    <a href="{{ route('admin.libros_virtuales.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Libro Virtual
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
                        <th>Peso Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($libros as $libro)
                    <tr>
                        <td>{{ $libro->id_libro_virtual }}</td>
                        <td>{{ $libro->titulo }}</td>
                        <td>{{ $libro->autor }}</td>
                        <td>{{ $libro->categoria->nombre_categoria }}</td>
                        <td>{{ $libro->peso_archivo }}</td>
                        <td>
                            {{-- Editar --}}
                            <a href="{{ route('admin.libros_virtuales.edit', $libro->id_libro_virtual) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            {{-- Eliminar --}}
                            <form action="{{ route('admin.libros_virtuales.destroy', $libro->id_libro_virtual) }}"
                                  method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Deseas eliminar este libro virtual?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>

                            {{-- Abrir Libro (URL externa) --}}
                            <a href="{{ $libro->url_archivo }}"
                               target="_blank"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-external-link-alt"></i> Abrir
                            </a>

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
   🎨 CARD PASTEL
========================================== */
.card {
    border-radius: 1.3rem !important;
    background: #ffffffee !important;
    border: 1px solid #c7e9f7 !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
}

/* ==========================================
   🎨 TABLA PASTEL – LISTA DE LIBROS
========================================== */
.table thead {
    background: #c8f0ff !important;
    color: #04445c !important;
    border-bottom: 2px solid #b6e8f7 !important;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background: #f4fbff !important;
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
   🎨 BOTONES PRINCIPALES
========================================== */

/* Crear */
.btn-primary {
    background: #6dccff !important;
    border-color: #6dccff !important;
    color: #003f5a !important;
    border-radius: .9rem !important;
    font-weight: 700 !important;
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
    font-weight: 600 !important;
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
    font-weight: 600 !important;
}

.btn-danger:hover {
    background: #ffb3b3 !important;
}

/* Abrir archivo */
.btn-info {
    background: #b5ecff !important;
    border-color: #b5ecff !important;
    color: #03445c !important;
    border-radius: .8rem !important;
    font-weight: 600 !important;
}

.btn-info:hover {
    background: #96e5ff !important;
}

</style>
@endpush
