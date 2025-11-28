<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dni','password','nombres','apellidos','semestre','turno','direccion','telefono','rol','estado'
    ];

    protected $hidden = ['password','remember_token'];

    // RELACIONES
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'dni_usuario', 'dni');
    }

    public function prestamosFisicos()
    {
        return $this->hasMany(PrestamoFisico::class, 'dni_usuario', 'dni');
    }

    public function accesosVirtuales()
    {
        return $this->hasMany(AccesoVirtual::class, 'dni_usuario', 'dni');
    }

    public function apuntesPersonales()
    {
        return $this->hasMany(ApuntePersonal::class, 'dni_usuario', 'dni');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'dni_usuario', 'dni');
    }

}
