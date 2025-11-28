@extends('layouts.admin')

@section('title', 'Usuarios con Más Lectura Virtual')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">💻 Usuarios con mayor lectura virtual</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Total Accesos Virtuales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->dni_usuario }}</td>
                <td>{{ $row->total_accesos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
