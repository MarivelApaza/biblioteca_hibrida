<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccesoVirtual extends Model
{
    use HasFactory;

    protected $table = 'accesos_virtuales';
    protected $primaryKey = 'id_acceso';

    protected $fillable = [
        'dni_usuario',
        'id_libro_virtual',
        'token_seguridad',
        'fecha_generacion',
        'fecha_caducidad',
        'estado'
    ];

    public function libroVirtual()
    {
        return $this->belongsTo(LibroVirtual::class, 'id_libro_virtual');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'dni_usuario', 'dni');
    }
}
