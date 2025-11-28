<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroFisico extends Model
{
    use HasFactory;

    protected $table = 'libros_fisicos';
    protected $primaryKey = 'id_libro_fisico';

    protected $fillable = [
        'id_categoria', 'titulo', 'autor', 'isbn', 'editorial',
        'año_edicion', 'tipo_encuadernacion', 'estado_promedio',
        'stock_total', 'stock_disponible', 'ubicacion_pasillo',
        'imagen_portada', 'palabras_clave'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_libro_fisico');
    }

    public function prestamosFisicos()
    {
        return $this->hasMany(PrestamoFisico::class, 'id_libro_fisico');
    }


    public function libroFisico()
{
    return $this->belongsTo(LibroFisico::class, 'id_referencia', 'id_libro_fisico')
                ->where('tipo_recurso', 'FISICO');
}

    /** ⭐ AQUI EL ACCESSOR ⭐ */
    public function getUrlImagenPortadaAttribute()
    {
        if ($this->imagen_portada && file_exists(public_path('storage/' . $this->imagen_portada))) {
            return asset('storage/' . $this->imagen_portada);
        }

        return asset('img/no-image.png');
    }
}
