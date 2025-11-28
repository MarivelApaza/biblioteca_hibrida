@extends('layouts.alumno')

@section('title', $apunte->titulo)

@section('content')
<div class="container">
    <div class="card shadow-sm librito p-4">
        <h3 class="mb-3"><i class="fas fa-book-open"></i> {{ $apunte->titulo }}</h3>
        <hr>
        <p style="white-space: pre-line;">{{ $apunte->contenido }}</p>
        <a href="{{ route('alumno.apuntes.index') }}" class="btn btn-primary mt-3"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>
</div>

<style>
.librito {
    border-radius: 0.5rem;
    background: linear-gradient(145deg, #fffbe6, #fff3c4);
    box-shadow: 5px 5px 15px rgba(0,0,0,0.1);
    padding: 2rem;
}
</style>
@endsection
