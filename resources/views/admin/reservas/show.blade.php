@extends('layouts.admin')

@section('title', 'Detalle de Reserva')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4"><i class="fas fa-eye"></i> Detalle de la Reserva</h1>

    <div class="row">

        {{-- Información del Alumno --}}
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>Datos del Alumno</strong>
                </div>
                <div class="card-body">
                    <p><strong>DNI:</strong> {{ $reserva->usuario->dni }}</p>
                    <p><strong>Nombre:</strong> {{ $reserva->usuario->nombres }} {{ $reserva->usuario->apellidos }}</p>
                    
                    <p><strong>Estado:</strong> {{ $reserva->usuario->estado }}</p>
                </div>
            </div>
        </div>

        {{-- Información del Libro --}}
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong>Datos del Libro</strong>
                </div>
                <div class="card-body">
                    <p><strong>Título:</strong> {{ $reserva->libroFisico->titulo }}</p>
                    <p><strong>Código:</strong> {{ $reserva->libroFisico->id_libro_fisico }}</p>
                    <p><strong>Ubicación:</strong> {{ $reserva->libroFisico->ubicacion_pasillo }}</p>
                    <p><strong>Categoría:</strong> {{ $reserva->libroFisico->categoria->nombre_categoria }}</p>
                    <p><strong>Stock Disponible:</strong> {{ $reserva->libroFisico->stock_disponible }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Información de la Reserva --}}
    <div class="card shadow-lg mb-3">
        <div class="card-header bg-dark text-white">
            <strong>Detalle de la Reserva</strong>
        </div>
        <div class="card-body">
            <p><strong>ID Reserva:</strong> {{ $reserva->id_reserva }}</p>
            <p><strong>Fecha Reserva:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</p>
            <p><strong>Fecha Límite de Recojo:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_limite_recojo)->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge bg-{{ $reserva->estado == 'ACTIVA' ? 'primary' : ($reserva->estado == 'EXPIRADA' ? 'danger' : 'success') }}">
                    {{ $reserva->estado }}
                </span>
            </p>
        </div>
    </div>

    {{-- Botón Volver --}}
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

</div>
@endsection
