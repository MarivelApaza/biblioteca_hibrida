<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'dni_usuario', 
        'id_libro_fisico', 
        'fecha_reserva', 
        'fecha_limite_recojo', // CORRECTO
        'estado'
    ];

    public function alumno()
    {
        return $this->belongsTo(User::class, 'dni_usuario');
    }

    public function libroFisico()
    {
        return $this->belongsTo(LibroFisico::class, 'id_libro_fisico');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'dni_usuario', 'dni');
    }

    public function libro()
    {
        return $this->belongsTo(LibroFisico::class, 'id_libro_fisico', 'id_libro_fisico');
    }
}
