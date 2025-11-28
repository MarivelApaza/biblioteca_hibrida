@extends('layouts.admin')

@section('title', 'Libros Virtuales Más Leídos')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">📕 Libros Virtuales Más Leídos</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Total Accesos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->titulo }}</td>
                <td>{{ $row->total_accesos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
