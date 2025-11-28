<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'ADMINISTRADOR']);
        $alumnoRole = Role::firstOrCreate(['name' => 'ALUMNO']);

        // ADMINISTRADOR
        $admin = User::updateOrCreate(
            ['dni' => '00000001'],
            [
                'password'   => Hash::make('admin123'),
                'nombres'    => 'Carlos',
                'apellidos'  => 'Ramirez Torres',
                'semestre'   => null,
                'turno'      => null,
                'direccion'  => 'Av. Los Olivos 123',
                'telefono'   => '999111222',
                'rol'        => 'ADMINISTRADOR',
                'estado'     => 'ACTIVO',
            ]
        );
        $admin->syncRoles($adminRole); // <-- asigna el rol Spatie

        // ALUMNO 1
        $alumno1 = User::updateOrCreate(
            ['dni' => '00000002'],
            [
                'password'   => Hash::make('alumno123'),
                'nombres'    => 'Juan',
                'apellidos'  => 'Pérez Gonzales',
                'semestre'   => 'III',
                'turno'      => 'MAÑANA',
                'direccion'  => 'Jr. Lima 456',
                'telefono'   => '988123456',
                'rol'        => 'ALUMNO',
                'estado'     => 'ACTIVO',
            ]
        );
        $alumno1->syncRoles($alumnoRole);

        // ALUMNO 2
        $alumno2 = User::updateOrCreate(
            ['dni' => '00000003'],
            [
                'password'   => Hash::make('alumno123'),
                'nombres'    => 'María',
                'apellidos'  => 'Lopez Flores',
                'semestre'   => 'IV',
                'turno'      => 'NOCHE',
                'direccion'  => 'Av. Progreso 789',
                'telefono'   => '977654321',
                'rol'        => 'ALUMNO',
                'estado'     => 'ACTIVO',
            ]
        );
        $alumno2->syncRoles($alumnoRole);
    }
}
