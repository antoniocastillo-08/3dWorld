<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        // Crear permisos específicos para el rol de Boss
        $permissions = [
            'edit company data',
            'delete company',
            'accept employee requests',
            'reject employee requests',
            'remove employees from company',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear el rol de Boss y asignarle los permisos
        $bossRole = Role::create(['name' => 'boss']);
        $bossRole->givePermissionTo($permissions);
    }
}