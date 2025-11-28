@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4"><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h1>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="semestre" class="form-label">Semestre</label>
                    <input type="text" name="semestre" id="semestre" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="turno" class="form-label">Turno</label>
                    <select name="turno" id="turno" class="form-select">
                        <option value="MAÑANA">Mañana</option>
                        <option value="NOCHE">Noche</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" id="rol" class="form-select">
                        <option value="ALUMNO">Alumno</option>
                        <option value="ADMINISTRADOR">Administrador</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="ACTIVO">Activo</option>
                        <option value="SANCIONADO">Sancionado</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button class="btn btn-primary"><i class="fas fa-save"></i> Guardar Usuario</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
/* =====================================================
   🌟 TÍTULO PRINCIPAL – Estilo moderno institucional
======================================================*/
h1.mb-4 {
    color: #05668d !important;
    font-weight: 900 !important;
    letter-spacing: .5px;
    text-shadow: 1px 1px 2px #c8f5ff;
}

/* =====================================================
   🌟 TARJETA DEL FORMULARIO – Blanco premium pastel
======================================================*/
.card {
    border-radius: 1.4rem !important;
    background: linear-gradient(135deg, #ffffff 0%, #f4fcff 100%) !important;
    border: 1px solid #b9e6f6 !important;
    box-shadow: 0 8px 25px rgba(0, 91, 128, 0.10) !important;
    padding: 1.5rem !important;
}

/* =====================================================
   🌟 LABELS – Claros, minimalistas
======================================================*/
.form-label {
    font-weight: 700;
    color: #04445c;
    margin-bottom: .35rem;
    letter-spacing: .3px;
}

/* =====================================================
   🌟 INPUTS – Turquesa pastel elegante
======================================================*/
.form-control, 
.form-select {
    border-radius: .9rem !important;
    border: 1px solid #bfe9f7 !important;
    background: #f9fdff !important;
    font-size: .95rem !important;
    padding: .55rem .9rem !important;
    color: #04445c !important;
}

.form-control:focus, 
.form-select:focus {
    border-color: #73d2f6 !important;
    box-shadow: 0 0 0 .18rem rgba(115,210,246,.35) !important;
    background: #ffffff !important;
}

/* =====================================================
   🌟 BOTÓN PRINCIPAL – Celeste pastel destacado
======================================================*/
.btn-primary {
    background: linear-gradient(135deg, #73d2f6, #53c0e9) !important;
    border: none !important;
    border-radius: .9rem !important;
    color: #003f5a !important;
    font-weight: 700 !important;
    padding: .65rem 1.4rem !important;
    box-shadow: 0 6px 20px rgba(83,192,233,0.35) !important;
    transition: .2s ease-in-out;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5ec6ec, #3ab3e0) !important;
    transform: translateY(-2px);
}

/* =====================================================
   🌟 BOTÓN ELIMINAR – Rojo pastel suave
======================================================*/
.btn-danger {
    background: #ffd1d1 !important;
    border: none !important;
    color: #8a1b1b !important;
    border-radius: .9rem !important;
    font-weight: 600 !important;
}

.btn-danger:hover {
    background: #ffb7b7 !important;
    transform: translateY(-2px);
}

/* =====================================================
   🌟 BOTÓN EDITAR – Amarillo pastel
======================================================*/
.btn-warning {
    background: #ffe9a9 !important;
    border: none !important;
    color: #7c5a00 !important;
    border-radius: .9rem !important;
    font-weight: 600 !important;
}

.btn-warning:hover {
    background: #ffdd80 !important;
    transform: translateY(-2px);
}

/* =====================================================
   🌟 ADICIONAL: Resaltar campos obligatorios
======================================================*/
input[required], select[required] {
    background-image: linear-gradient(to right, #73d2f6, #73d2f6);
    background-size: 2px 100%;
    background-position: right;
    background-repeat: no-repeat;
}

</style>
@endpush