@extends('layouts.alumno')

@section('title', 'Mis Favoritos')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-heart"></i> Mis Favoritos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($favoritos->isEmpty())
        <div class="alert alert-warning">
            No tienes favoritos aún. Busca libros en el catálogo y agrégalos aquí.
        </div>
    @else
        <div class="card shadow-lg">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($favoritos as $fav)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- Libro físico --}}
                            @if($fav->tipo_recurso === 'FISICO' && $fav->libroFisico)
                                <td>{{ $fav->libroFisico->titulo }}</td>
                                <td>{{ $fav->libroFisico->autor }}</td>
                                <td>{{ $fav->libroFisico->categoria->nombre_categoria ?? '-' }}</td>
                                <td>Físico</td>
                                <td>
                                    <a href="{{ route('alumno.catalogo.showFisico', $fav->libroFisico->id_libro_fisico) }}" 
                                       class="btn btn-sm btn-primary mb-1">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <form action="{{ route('alumno.favoritos.destroy', $fav->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Eliminar de favoritos?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>

                            {{-- Libro virtual --}}
                            @elseif($fav->tipo_recurso === 'VIRTUAL' && $fav->libroVirtual)
                                <td>{{ $fav->libroVirtual->titulo }}</td>
                                <td>{{ $fav->libroVirtual->autor }}</td>
                                <td>{{ $fav->libroVirtual->categoria->nombre_categoria ?? '-' }}</td>
                                <td>Virtual</td>
                                <td>
                                    <a href="{{ route('alumno.accesos.create', $fav->libroVirtual->id_libro_virtual) }}" 
                                       class="btn btn-sm btn-success mb-1">
                                        <i class="fas fa-book-open"></i> Leer ahora
                                    </a>
                                    <form action="{{ route('alumno.favoritos.destroy', $fav->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Eliminar de favoritos?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>

/* ============================
   💜 TITULO PRINCIPAL
============================ */
h1 i {
    color: #ff6fa6;
}
h1 {
    font-weight: 800;
    color: #064663;
}

/* ============================
   📦 CARD PRINCIPAL
============================ */
.card {
    border-radius: 18px !important;
    background: #ffffff;
    border: 2px solid #d9f8ff !important;
    transition: .25s ease;
}

.card:hover {
    box-shadow: 0 10px 28px rgba(134, 133, 133, 0.12);
    border-color: #7de3e0 !important;
}

/* ============================
   📑 TABLA PASTEL
============================ */
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #bcdfecff !important;
}

.table-hover tbody tr:hover {
    background-color: #e9fbff !important;
    transition: .2s ease;
}

.table-dark {
    background: linear-gradient(135deg, #7de3e0, #56c9d6) !important;
    border: none;
}
.table-dark th {
    color: #6bd2e2ff !important;
    font-weight: 700;
}

/* ============================
   🎀 BADGES
============================ */
.badge {
    border-radius: 10px;
    padding: .45rem .65rem;
    font-weight: 600;
}

/* ============================
   🎯 BOTONES
============================ */

/* 👁 Ver */
.btn-primary {
    background: linear-gradient(135deg, #b3ecff, #7de3e0);
    border: none !important;
    font-weight: 600;
    color: #064663 !important;
    border-radius: 10px !important;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #64d9f5, #4fc9cc);
    color: #083b43 !important;
}

/* 📖 Leer ahora */
.btn-success {
    background: linear-gradient(135deg, #a8f2df, #4ed9b2);
    border: none !important;
    font-weight: 600;
    border-radius: 10px !important;
}
.btn-success:hover {
    background: linear-gradient(135deg, #5fd9b9, #34c49c);
}

/* 🗑 Eliminar */
.btn-danger {
    background: linear-gradient(135deg, #ff9eb5, #ff6f91);
    border: none !important;
    font-weight: 600;
    border-radius: 10px !important;
}
.btn-danger:hover {
    background: linear-gradient(135deg, #ff6f91, #ff4d78);
}

/* ============================
   ⚠️ MENSAJES
============================ */
.alert-success {
    background: #d4fdf2;
    color: #065f46;
    border-radius: 12px;
    border: 1px solid #9df3dc;
}

.alert-info {
    background: #d9f2ff;
    color: #055f7a;
    border-radius: 12px;
    border: 1px solid #9df0ff;
}

.alert-warning {
    background: #fff7d1;
    color: #8a6d00;
    border-radius: 12px;
    border: 1px solid #ffe8a3;
}

/* ============================
   ✨ TABLA CELDAS
============================ */
td, th {
    vertical-align: middle !important;
}

/* ============================
   ✨ EFECTOS
============================ */
table tr {
    transition: .25s ease;
}

</style>
@endpush
