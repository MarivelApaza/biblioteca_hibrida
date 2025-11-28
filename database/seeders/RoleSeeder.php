<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Guard por defecto
        $guardName = 'web';

        // Roles necesarios
        Role::firstOrCreate(['name' => 'ADMINISTRADOR', 'guard_name' => $guardName]);
        Role::firstOrCreate(['name' => 'ALUMNO', 'guard_name' => $guardName]);
    }
}
