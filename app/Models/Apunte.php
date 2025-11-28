<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Apunte extends Model
{
    use HasFactory;

    protected $table = 'apuntes_personales';
    protected $primaryKey = 'id_apunte';
    protected $fillable = [
        'dni_usuario',
        'id_libro_virtual',
        'pagina_pdf',
        'texto_nota',
    ];

    /**
     * Solo apuntes del usuario autenticado
     */
    public static function misApuntes()
    {
        return self::where('dni_usuario', Auth::user()->dni)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Relación con LibroVirtual
     */
    public function libroVirtual()
    {
        return $this->belongsTo(LibroVirtual::class, 'id_libro_virtual', 'id_libro_virtual');
    }
}
