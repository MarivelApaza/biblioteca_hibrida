@extends('layouts.alumno')

@section('title', 'Reservar Libro')

@section('content')
<div class="container">
    <h3>Reservar Libro</h3>

    {{-- MENSAJE SI YA RESERVÓ EL LIBRO --}}
    @if (session('info'))
        <div class="alert alert-warning">
            {{ session('info') }}
        </div>
    @endif

    <div class="card p-4 shadow">
        <h4>{{ $libro->titulo }}</h4>
        <p>Autor: {{ $libro->autor }}</p>
        <p>Stock disponible: {{ $libro->stock_disponible }}</p>

        <form action="{{ route('alumno.reservas.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_libro_fisico" value="{{ $libro->id_libro_fisico }}">

            <div class="alert alert-info">
                📅 *Recuerda:* Tienes **1días** para recoger tu libro en biblioteca.
            </div>

            <button class="btn btn-success btn-lg">Confirmar Reserva</button>
        </form>
    </div>
</div>
@endsection
