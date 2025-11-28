<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LibroFisico;

class PrestamoFisico extends Model
{
    use HasFactory;

    protected $table = 'prestamos_fisicos';
    protected $primaryKey = 'id_prestamo';

    protected $fillable = [
        'dni_usuario',
        'id_libro_fisico',
        'fecha_salida',
        'fecha_devolucion_programada',
        'fecha_devolucion_real',
        'estado',
        'observaciones_devolucion',
    ];

    // Transformar automáticamente a Carbon
    protected $casts = [
        'fecha_salida' => 'datetime',
        'fecha_devolucion_programada' => 'date',
        'fecha_devolucion_real' => 'datetime',
    ];

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'dni_usuario', 'dni');
    }

    // Relación con libro físico
    public function libroFisico()
    {
        return $this->belongsTo(LibroFisico::class, 'id_libro_fisico', 'id_libro_fisico');
    }
}
