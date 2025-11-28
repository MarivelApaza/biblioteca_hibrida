@extends('layouts.alumno')

@section('title', 'Acceso a Libro Virtual')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-file-pdf"></i> {{ $libro->titulo }}</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            @if($acceso->estado === 'ACTIVO' && now() <= \Carbon\Carbon::parse($acceso->fecha_caducidad))
                <iframe src="{{ route('alumno.accesos_virtuales.stream', $acceso->token_seguridad) }}" 
                        style="width:100%; height:600px;" frameborder="0"></iframe>
            @else
                <div class="alert alert-danger">
                    Acceso denegado. El token ha caducado o no es válido.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
