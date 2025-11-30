@extends('layouts.alumno')
@section('title', 'Mis Apuntes')

@section('content')
<div class="container">
    <h3>📖 Mis Apuntes</h3>
    <a href="{{ route('alumno.apuntes.create', ['id_libro' => 1]) }}" class="btn btn-primary mb-3">+ Nuevo Apunte</a>
<br>
<br>
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
                                <br>
        </div>
        @empty
        <p>No tienes apuntes aún.</p>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>

/* =====================================================
   ✨ TIPOGRAFÍA LIMPIA
===================================================== */
body, h3, p, .card, button {
    font-family: 'Poppins','Nunito',sans-serif !important;
}


/* =====================================================
   📝 TÍTULO
===================================================== */
h3 {
    font-weight: 800 !important;
    font-size: 2rem !important;
    color: #044a5d !important;
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 4px rgba(0,70,90,0.08);
}

h3::after {
    content:"";
    width: 70px;
    height: 4px;
    border-radius: 8px;
    background: linear-gradient(90deg,#c7f3ff,#9ee6f2);
}


/* =====================================================
   🌤 FONDO CELESTE SUPER SUAVE
===================================================== */
body {
    background: linear-gradient(180deg,#fafdff,#f3faff,#eef8fb) !important;
}


/* =====================================================
   📌 TARJETA (stick note) — ULTRA SOFT
===================================================== */
.card {
    position: relative;
    border-radius: 18px !important;
    padding-top: 42px !important;
    border: none !important;
    width: 100%;
    background: #ffffffee !important;
    box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    transition: .3s ease;
    cursor: default;
}

/* rotación MUY sutil */
.card:nth-child(odd) { transform: rotate(-0.6deg); }
.card:nth-child(even) { transform: rotate(0.7deg); }

.card:hover {
    transform: scale(1.02) rotate(0deg);
    box-shadow: 0 14px 30px rgba(0,0,0,0.10);
}


/* =====================================================
   🎀 CINTA SUPER SUAVE (solo celeste muy pálido)
===================================================== */
.card::before {
    content:"";
    position: absolute;
    top:-12px;
    left:50%;
    transform: translateX(-50%) rotate(-2.2deg);
    width: 85px;
    height: 26px;
    background: rgba(180, 225, 240, 0.35);
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    backdrop-filter: blur(3px);
    border: 1px solid rgba(160,210,230,0.25);
}


/* =====================================================
   📑 ESQUINA DOBLADA, PERO CELESTE MUY FINO
===================================================== */
.card::after {
    content:"";
    position: absolute;
    bottom: 0;
    right: 0;
    width: 26px;
    height: 26px;
    background: linear-gradient(135deg,#e8f7fb, #d6f0f5);
    clip-path: polygon(0 0,100% 100%,100% 0);
    box-shadow: -2px -2px 4px rgba(0,0,0,0.05);
}


/* =====================================================
   🩵 CABECERA STICK NOTE (solo turquesa pastel)
===================================================== */
.card-header {
    background: linear-gradient(90deg,#d6f8ff,#b8eef7) !important;
    color:#044a5d !important;
    border-radius: 18px 18px 0 0 !important;
    font-weight: 700 !important;
    font-size: .95rem;
    text-align:center;
    padding: .65rem !important;
}


/* =====================================================
   ✍ TEXTO
===================================================== */
.card-body {
    padding: 1rem 1.3rem !important;
    color:#325c63;
    font-size: .92rem;
    line-height: 1.55rem;
}

.card-body p strong {
    color:#044a5d !important;
}


/* =====================================================
   🎛 BOTONES — CELESTE PREMIUM ELEGANTE
===================================================== */

/* --- BOTÓN: Nuevo Apunte --- */
.btn-primary {
    background: linear-gradient(135deg, #40a2b8ff, #8fe0ec) !important;
    color: #034a5b !important;
    padding: .7rem 1.5rem !important;
    border-radius: 14px !important;
    font-weight: 800 !important;
    border: none !important;
    letter-spacing: .4px;
    box-shadow: 0 6px 14px rgba(0, 150, 170, 0.25);
    transition: .28s ease;
}
.btn-primary:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg, #a6ecff, #78d3e1) !important;
    box-shadow: 0 10px 22px rgba(0, 150, 170, 0.32);
}


/* --- BOTÓN: Editar --- */
.btn-warning {
    background: linear-gradient(135deg, #86daceff, #8bd3c9ff) !important;
    color: #225b6a !important;
    border-radius: 12px !important;
    border: 1px solid #b8e4f0 !important;
    font-weight: 700 !important;
    padding: .45rem 1rem !important;
    transition: .25s ease;
}
.btn-warning:hover {
    background: linear-gradient(135deg, #d3f0ff, #b4e4f2) !important;
    box-shadow: 0 4px 12px rgba(0, 130, 150, 0.18);
}


/* --- BOTÓN: Eliminar --- */
.btn-danger {
    background: linear-gradient(135deg, #cff3ff, #a8e4f2) !important;
    color: #114452 !important;
    border-radius: 12px !important;
    border: 1px solid #9edced !important;
    font-weight: 700 !important;
    padding: .45rem 1rem !important;
    transition: .25s ease;
}
.btn-danger:hover {
    background: linear-gradient(135deg, #baeaff, #94d7e6) !important;
    box-shadow: 0 4px 12px rgba(0, 130, 150, 0.18);
}



/* =====================================================
   💙 “Nuevo Apunte”
===================================================== */
.btn-primary {
    background: linear-gradient(135deg,#c7f4ff,#9fe7f0) !important;
    color:#064f63 !important;
    padding:.65rem 1.3rem !important;
    border-radius:14px !important;
    font-weight:700 !important;
    border:none !important;
    transition:.25s ease;
    box-shadow:0 4px 10px rgba(0,110,130,0.15);
}
.btn-primary:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg,#b1effc,#8fe0ec) !important;
}


/* =====================================================
   🎨 COLORES SUAVES ROTATIVOS SOLO CELESTE
===================================================== */
.card:nth-child(1) { background:#f4fcff !important; }
.card:nth-child(2) { background:#eefaff !important; }
.card:nth-child(3) { background:#e9f7ff !important; }
.card:nth-child(4) { background:#f2fdff !important; }
.card:nth-child(5) { background:#e8f6fb !important; }

</style>
@endpush
