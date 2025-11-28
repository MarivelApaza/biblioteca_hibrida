<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroVirtual extends Model
{
    use HasFactory;

    protected $table = 'libros_virtuales';
    protected $primaryKey = 'id_libro_virtual';

    protected $fillable = [
        'id_categoria',
        'titulo',
        'autor',
        'resumen_sinopsis',
        'url_archivo',
        'peso_archivo',
        'imagen_portada',
        'palabras_clave'
    ];

    // 🔹 Agregamos el accessor para que Laravel genere la URL correcta
    protected $appends = ['url_imagen_portada'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function accesosVirtuales()
    {
        return $this->hasMany(AccesoVirtual::class, 'id_libro_virtual');
    }

    public function apuntesPersonales()
    {
        return $this->hasMany(Apunte::class, 'id_libro_virtual');
    }

    public function libroVirtual()
{
    return $this->belongsTo(LibroVirtual::class, 'id_referencia', 'id_libro_virtual')
                ->where('tipo_recurso', 'VIRTUAL');
}

    /**
     * 🔥 Devuelve la URL correcta de la portada sin duplicar rutas
     */
    public function getUrlImagenPortadaAttribute()
    {
        // Si no tiene portada → imagen por defecto
        if (!$this->imagen_portada) {
            return asset('img/default-book.png');
        }

        // Si en BD ya viene 'libros_virtuales/archivo.jpg', limpiamos duplicados
        $file = str_replace('libros_virtuales/', '', $this->imagen_portada);

        // URL final correcta
        return asset('storage/libros_virtuales/' . $file);
    }
}
