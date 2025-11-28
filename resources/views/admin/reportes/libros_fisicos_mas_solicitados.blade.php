@extends('layouts.admin')

@section('title', 'Libros Físicos Más Solicitados')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">📘 Libros Físicos Más Solicitados</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Total Solicitudes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->titulo }}</td>
                <td>{{ $row->total_solicitudes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
