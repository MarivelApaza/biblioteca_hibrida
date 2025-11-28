@extends('layouts.app')

@section('content')
<h3>Selecciona un libro para crear apuntes</h3>
<ul>
@foreach($libros as $libro)
    <li>
        {{ $libro->titulo }} - 
        <a href="{{ route('alumno.apuntes.create', $libro->id_libro_virtual) }}">Crear Apunte</a>
    </li>
@endforeach
</ul>
@endsection
