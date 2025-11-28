@extends('layouts.admin')

@section('title', 'Usuarios con Más Préstamos')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">👨‍🎓 Usuarios con más préstamos</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Total Préstamos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->dni_usuario }}</td>
                <td>{{ $row->total_prestamos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
