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

/* ======================================================
   🌟 TÍTULO PRINCIPAL
====================================================== */
h1.mb-4 {
    font-weight: 900;
    color: #033b47;
    text-shadow: 0 3px 10px rgba(0, 90, 110, 0.25);
    letter-spacing: .6px;
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ======================================================
   🔎 BUSCADOR — EFECTO GLASS
====================================================== */
.input-group-lg input {
    border-radius: 14px 0 0 14px !important;
    border: 2px solid #b3ecff !important;
    background: rgba(255, 255, 255, 0.65) !important;
    backdrop-filter: blur(6px);
    box-shadow: 0 4px 10px rgba(0, 140, 170, 0.12);
}

.input-group-lg .btn-primary {
    background: linear-gradient(135deg, #6ed9e8, #4cbfd9);
    font-weight: 700;
    border-radius: 0 14px 14px 0 !important;
    box-shadow: 0 6px 14px rgba(0,140,170,0.25);
}

.input-group-lg .btn-primary:hover {
    background: linear-gradient(135deg, #4bbdd4, #37a7c3);
    transform: translateX(2px);
}

/* ======================================================
   🏷 CATEGORÍAS — CHIPS PREMIUM
====================================================== */

.btn-outline-primary {
    border-color: #8eeaf3 !important;
    color: #056674 !important;
    border-radius: 20px !important;
    padding: .35rem 1rem !important;
    transition: .25s ease;
}

.btn-outline-primary:hover,
.btn-outline-primary.active {
    background: linear-gradient(135deg, #7de3e0, #4dcfe0) !important;
    color: #033b47 !important;
    font-weight: 700;
    border-color: transparent !important;
    box-shadow: 0 6px 12px rgba(0,140,170,0.18);
}

.btn-secondary.active {
    background: linear-gradient(135deg, #b3ecff, #89d4e6) !important;
    color: #033b47 !important;
    border-radius: 20px !important;
    font-weight: 700;
}

/* ======================================================
   📚 TARJETAS DE LIBROS — NIVEL PREMIUM++
====================================================== */
.card {
    border-radius: 18px !important;
    background: rgba(255, 255, 255, 0.9) !important;
    backdrop-filter: blur(6px);
    border: 2px solid #d7f8ff !important;
    transition: .35s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.card:hover {
    transform: translateY(-7px) scale(1.02);
    border-color: #7de3e0 !important;
    box-shadow: 0 16px 35px rgba(0,130,150,0.20);
}

.card-img-top {
    border-bottom: 3px solid #c6f7ef;
    transition: .3s ease;
}

.card:hover .card-img-top {
    filter: brightness(1.1);
}

/* Títulos */
.card-title {
    font-weight: 800;
    letter-spacing: .4px;
}

/* ======================================================
   🎛 ACCIONES & BOTONES
====================================================== */

.btn-info {
    background: linear-gradient(135deg, #b3ecff, #6ed9e8);
    border: none !important;
    font-weight: 700;
    box-shadow: 0 6px 15px rgba(0,165,190,0.25);
}

.btn-info:hover {
    background: linear-gradient(135deg, #57c6d9, #3cb3c5);
    color: white !important;
    transform: translateY(-2px);
}

/* Botón para libros físicos */
.btn-success {
    background: linear-gradient(135deg, #a8f2df, #4ed9b2);
    border: none !important;
    font-weight: 700;
    box-shadow: 0 6px 15px rgba(60,190,160,0.25);
}

.btn-success:hover {
    background: linear-gradient(135deg, #57d9b9, #2ebd99);
    transform: translateY(-2px);
}

/* Corazón favorito */
.btn-outline-danger {
    border-radius: 50% !important;
    border-width: 2px !important;
    transition: .25s ease;
}

.btn-outline-danger:hover {
    background: #ff88a0;
    color: white;
    border-color: #ff88a0;
    box-shadow: 0 5px 12px rgba(255,90,110,0.3);
}

/* ======================================================
   📦 BADGES (stock disponibles)
====================================================== */
.badge.bg-success {
    background-color: #4ed9b2 !important;
    padding: .40rem .7rem !important;
    border-radius: 12px !important;
    font-weight: 800 !important;
    color: #033b32 !important;
}

/* ======================================================
   📑 PAGINACIÓN CELESTE
====================================================== */
.pagination .page-link {
    border-radius: 12px !important;
    border: 1px solid #c6f7ef !important;
    padding: .55rem .9rem !important;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #7de3e0, #4dcfe0);
    color: #033b47 !important;
    border: none !important;
    font-weight: 800;
}

/* ======================================================
   📱 RESPONSIVE
====================================================== */
@media (max-width: 768px) {
    .card-img-top { height: 220px !important; }
}

</style>
@endpush
