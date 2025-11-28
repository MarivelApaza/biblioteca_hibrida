@extends('layouts.alumno')
@section('title', 'Editar Apunte')

@section('content')
<div class="container">

    <h3>✏️ Editar Apunte</h3>

    <div class="book-page">

        <form action="{{ route('alumno.apuntes.update', $apunte->id_apunte) }}" method="POST">
            @csrf 
            @method('PUT')

            <div class="mb-3">
                <label>Página (opcional)</label>
                <input type="number" 
                       name="pagina_pdf" 
                       class="form-control" 
                       value="{{ old('pagina_pdf', $apunte->pagina_pdf) }}">
            </div>

            <div class="mb-3">
                <label>Texto del Apunte</label>
                <textarea name="texto_nota" 
                          class="form-control" 
                          rows="6">{{ old('texto_nota', $apunte->texto_nota) }}</textarea>
            </div>

            <button class="btn btn-success">Actualizar Apunte</button>
            <a href="{{ route('alumno.apuntes.index') }}" class="btn btn-secondary">Cancelar</a>

        </form>

    </div>

</div>
@endsection

@push('styles')
<style>

/* ================================
   📘 CONTENEDOR PRINCIPAL
================================ */
.container {
    max-width: 820px;
}

/* ================================
   📘 TÍTULO
================================ */
h3 {
    font-weight: 900;
    color: #04445c;
    margin-bottom: 1.2rem;
}

/* ================================
   📘 HOJA DE LIBRO / CUADERNO
================================ */
.book-page {
    background: repeating-linear-gradient(
        #ffffff,
        #ffffff 28px,
        #eaf6fb 29px
    );
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid #c8e7f5;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    position: relative;
}

/* Lomo izquierdo */
.book-page::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: -12px;
    width: 6px;
    border-radius: 10px;
    background: linear-gradient(
        to bottom,
        #9cd6e8,
        #7fc9df,
        #9cd6e8
    );
    box-shadow: 0 0 6px rgba(0,0,0,0.12);
}

/* ================================
   📘 LABELS
================================ */
label {
    font-weight: 700;
    color: #04445c;
}

/* ================================
   📘 INPUT Y TEXTAREA
================================ */
.form-control {
    background: #ffffffaa;
    border: 1px solid #b8dff0;
    border-radius: 10px;
    padding: .65rem .9rem;
    font-size: .95rem;
}

.form-control:focus {
    border-color: #7ccff2;
    box-shadow: 0 0 0 .16rem rgba(124,207,242,0.35);
    background: #fff;
}

/* Textarea estilo cuaderno */
textarea.form-control {
    background:
        linear-gradient(#bcdde622 1px, transparent 1px),
        linear-gradient(90deg, #bcdde622 1px, transparent 1px),
        #ffffffdd;
    background-size: 100% 32px, 32px 100%;
    border-radius: 14px;
    line-height: 2;
}

/* ================================
   📘 BOTONES
================================ */
.btn-success {
    background: #6fd6b9 !important;
    border-color: #6fd6b9 !important;
    color: #003f5a !important;
    font-weight: 700;
    padding: .55rem 1.4rem;
    border-radius: .9rem;
}
.btn-success:hover {
    background: #5bcdae !important;
}

.btn-secondary {
    background: #d2e9f5 !important;
    border-color: #d2e9f5 !important;
    color: #04445c !important;
    font-weight: 600;
    border-radius: .9rem;
}
.btn-secondary:hover {
    background: #c0dfef !important;
}

</style>
@endpush
