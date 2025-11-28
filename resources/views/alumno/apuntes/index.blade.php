@extends('layouts.alumno')
@section('title', 'Mis Apuntes')

@section('content')
<div class="container">
    <h3>📖 Mis Apuntes</h3>
    <a href="{{ route('alumno.apuntes.create', ['id_libro' => 1]) }}" class="btn btn-primary mb-3">+ Nuevo Apunte</a>

    <div class="row">
        @forelse($apuntes as $apunte)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border border-light">
                <div class="card-header bg-info text-white">
                    {{ $apunte->libroVirtual->titulo ?? 'Libro desconocido' }}
                </div>
                <div class="card-body">
                    <p><strong>Página:</strong> {{ $apunte->pagina_pdf ?? 'N/A' }}</p>
                    <p>{{ Str::limit($apunte->texto_nota, 100) }}</p>
                    <a href="{{ route('alumno.apuntes.edit', $apunte->id_apunte) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('alumno.apuntes.destroy', $apunte->id_apunte) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este apunte?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p>No tienes apuntes aún.</p>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>

/* ================================
   🎨 TÍTULO PRINCIPAL
================================ */
h3 {
    font-weight: 900;
    color: #04445c;
    margin-bottom: 1rem;
}

/* ================================
   🎨 CONTENEDOR DE TARJETAS
================================ */
.card {
    border-radius: 1.1rem !important;
    background: #ffffffee;
    border: 1px solid #c8ecf5 !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06) !important;
    transition: transform .2s ease, box-shadow .2s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.12) !important;
}

/* ================================
   🎨 CABECERA DE LA TARJETA
================================ */
.card-header {
    background: linear-gradient(90deg, #8de3ff, #5ac8f5) !important;
    color: #003f5a !important;
    font-weight: 700;
    border-top-left-radius: 1rem !important;
    border-top-right-radius: 1rem !important;
}

/* ================================
   🎨 TEXTO DEL CUERPO
================================ */
.card-body p {
    color: #34515e;
    font-size: .9rem;
}

/* ================================
   🎨 BOTONES
================================ */

/* Nuevo Apunte */
.btn-primary {
    background: #6dccff !important;
    border-color: #6dccff !important;
    color: #003f5a !important;
    font-weight: 700 !important;
    border-radius: .8rem !important;
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
    background: #ffd4d4 !important;
    border-color: #ffd4d4 !important;
    color: #8a1d1d !important;
    font-weight: 600 !important;
    border-radius: .8rem !important;
}
.btn-danger:hover {
    background: #ffb3b3 !important;
}

/* ================================
   🎨 VACÍO
================================ */
.empty-text {
    color: #4e656e;
    font-size: 1rem;
    margin-top: 1rem;
}


</style>
@endpush
