@extends('layouts.alumno')

@section('title', 'Catálogo Híbrido')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">
        <i class="fas fa-book"></i> Catálogo de Libros 
    </h1>

    {{-- 🔎 Buscador --}}
    <form method="GET" action="{{ route('alumno.catalogo.index') }}" class="mb-4">
        <div class="input-group input-group-lg">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Buscar por título o autor..." 
                   value="{{ $query ?? '' }}">
            <button class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    {{-- 🟧 FILTRO POR CATEGORÍAS --}}
    <h4 class="mt-4 mb-3"><i class="fas fa-tags"></i> Categorías</h4>

    <div class="mb-4">
        <a href="{{ route('alumno.catalogo.index') }}"
           class="btn btn-secondary btn-sm me-2 {{ !$categoriaId ? 'active' : '' }}">
            Todos
        </a>
        @foreach($categorias as $cat)
            <a href="{{ route('alumno.catalogo.index', ['categoria' => $cat->id_categoria]) }}"
               class="btn btn-outline-primary btn-sm me-2 {{ $categoriaId == $cat->id_categoria ? 'active' : '' }}">
                {{ $cat->nombre_categoria }}
            </a>
        @endforeach
    </div>

    {{-- 🔵 LIBROS VIRTUALES --}}
    <h3 class="mb-3 text-info">
        <i class="fas fa-tablet-alt"></i> Libros Virtuales
    </h3>

    <div class="row">
        @forelse($librosVirtuales as $libro)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-lg border-0 position-relative">

                <img src="{{ $libro->url_imagen_portada }}"
                     class="card-img-top"
                     style="height: 300px; object-fit: cover">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary">{{ $libro->titulo }}</h5>
                    <p class="text-muted mb-1"><strong>Autor:</strong> {{ $libro->autor }}</p>
                    <p class="card-text text-truncate">{{ $libro->resumen_sinopsis }}</p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <a href="{{ route('alumno.catalogo.showVirtual', $libro->id_libro_virtual) }}"
                           class="btn btn-info text-white">
                            <i class="fas fa-eye"></i> Ver
                        </a>

                        <form method="POST" action="{{ route('alumno.favoritos.store') }}">
                            @csrf
                            <input type="hidden" name="id_referencia" value="{{ $libro->id_libro_virtual }}">
                            <input type="hidden" name="tipo_recurso" value="VIRTUAL">
                            <button type="submit" class="btn btn-outline-danger" title="Agregar a favoritos">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">No se encontraron libros virtuales.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mb-5">
        {{ $librosVirtuales->withQueryString()->links() }}
    </div>

    {{-- 🟢 LIBROS FÍSICOS --}}
    <h3 class="mt-5 mb-3 text-success">
        <i class="fas fa-library"></i> Libros de la Biblioteca Presencial
    </h3>

    <div class="row">
        @forelse($librosFisicos as $libro)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-lg border-0 position-relative">

                <img src="{{ $libro->url_imagen_portada }}"
                     class="card-img-top"
                     style="height: 300px; object-fit: cover">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-success">{{ $libro->titulo }}</h5>
                    <p class="text-muted mb-1"><strong>Autor:</strong> {{ $libro->autor }}</p>
                    <p><strong>Disponibles:</strong> <span class="badge bg-success">{{ $libro->stock_disponible }}</span></p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <a href="{{ route('alumno.catalogo.showFisico', $libro->id_libro_fisico) }}"
                           class="btn btn-success">
                            <i class="fas fa-eye"></i> Ver
                        </a>

                        <form method="POST" action="{{ route('alumno.favoritos.store') }}">
                            @csrf
                            <input type="hidden" name="id_referencia" value="{{ $libro->id_libro_fisico }}">
                            <input type="hidden" name="tipo_recurso" value="FISICO">
                            <button type="submit" class="btn btn-outline-danger" title="Agregar a favoritos">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">No se encontraron libros físicos.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $librosFisicos->withQueryString()->links() }}
    </div>

</div>
@endsection

@push('styles')
<style>

/* ============================
   🎨 TITULOS
============================ */
h1 i, h3 i {
    opacity: .8;
}

h1 {
    font-weight: 800;
    color: #064663;
}

h3.text-info {
    color: #1c7fb8 !important;
}

h3.text-success {
    color: #0f7a6a !important;
}

/* ============================
   🔎 BUSCADOR
============================ */
.input-group-lg input {
    border-radius: 14px 0 0 14px !important;
    border: 2px solid #b3ecff !important;
}

.input-group-lg .btn-primary {
    background: linear-gradient(135deg, #7de3e0, #56c9d6);
    border: none !important;
    padding: 0 2rem;
    border-radius: 0 14px 14px 0 !important;
    font-weight: 600;
}

.input-group-lg .btn-primary:hover {
    background: linear-gradient(135deg, #4dccd4, #64dce9);
}


/* ============================
   🟧 CATEGORÍAS
============================ */
.btn-outline-primary {
    border-color: #7de3e0 !important;
    color: #056674 !important;
    border-radius: 12px !important;
    padding: .4rem .9rem;
}
.btn-outline-primary:hover,
.btn-outline-primary.active {
    background-color: #7de3e0 !important;
    color: #024a53 !important;
    font-weight: 700;
}

.btn-secondary.active {
    background-color: #b3ecff !important;
    color: #064663;
    border: none !important;
}


/* ============================
   📚 TARJETAS DE LIBROS
============================ */
.card {
    border-radius: 16px !important;
    overflow: hidden;
    transition: .3s ease;
    background: #ffffff;
    border: 2px solid #d9f8ff !important;
}

.card:hover {
    transform: translateY(-6px) scale(1.015);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12) !important;
    border-color: #7de3e0 !important;
}

.card-title {
    font-weight: 700;
}

/* Imagen de portada */
.card-img-top {
    border-bottom: 3px solid #c6f7ef;
}


/* ============================
   🟣 ICONOS Y BOTONES
============================ */
.btn-info {
    background: linear-gradient(135deg, #b3ecff, #7de3e0);
    border: none !important;
    font-weight: 600;
}

.btn-info:hover {
    background: linear-gradient(135deg, #64d9f5, #4fc9cc);
    color: #083b43;
}

.btn-success {
    background: linear-gradient(135deg, #a8f2df, #4ed9b2);
    border: none !important;
    font-weight: 600;
}
.btn-success:hover {
    background: linear-gradient(135deg, #5fd9b9, #34c49c);
    color: white;
}

.btn-outline-danger {
    border-radius: 50% !important;
    font-size: 1.1rem;
    padding: .45rem .6rem !important;
    transition: .25s ease;
}

.btn-outline-danger:hover {
    background: #ff8aa0;
    color: white;
    border-color: #ff8aa0;
}


/* ============================
   🟢 BADGES
============================ */
.badge.bg-success {
    background-color: #4ed9b2 !important;
    color: #033e32 !important;
    padding: .45rem .7rem;
    border-radius: 10px;
    font-weight: 700;
}


/* ============================
   📑 PAGINACIÓN
============================ */
.pagination .page-link {
    border-radius: 10px !important;
    border: 1px solid #c6f7ef !important;
    color: #055d72 !important;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #7de3e0, #4dcfe0);
    border: none !important;
    font-weight: 700;
    color: #033843 !important;
}


/* ============================
   ✨ RESPONSIVE
============================ */
@media (max-width: 768px) {
    .card-img-top {
        height: 220px !important;
    }
}

</style>
@endpush
