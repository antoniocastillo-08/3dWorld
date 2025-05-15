<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        $permissions = [
            'edit printers',
            'delete printers',
            'create printers',
            'edit models',
            'delete models',
            'create models',
            'delete users', 
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear el rol de administrador si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Asignar todos los permisos al rol de administrador
        $adminRole->syncPermissions($permissions);

        // Crear el usuario administrador
        $admin = User::updateOrCreate(
            ['email' => 'admin@3dworld.com'], // Evitar duplicados
            [
                'name' => 'CastilloAdmin',
                'password' => bcrypt('contraseña'), 
            ]
        );

        // Asignar el rol de administrador al usuario
        $admin->assignRole($adminRole);
    }
}