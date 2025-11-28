<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = ['nombre_categoria', 'descripcion'];

    // Relaciones
    public function librosFisicos()
    {
        return $this->hasMany(LibroFisico::class, 'id_categoria');
    }

    public function librosVirtuales()
    {
        return $this->hasMany(LibroVirtual::class, 'id_categoria');
    }
}
