<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Workstation;
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

        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $bossRole = Role::firstOrCreate(['name' => 'boss']);

        // Asignar todos los permisos al rol de administrador
        $adminRole->syncPermissions($permissions);

        // Crear la compañía "Admin"
        $adminCompany = Company::firstOrCreate(['name' => 'Admin', 'phone' => '1234567890', 'email' => 'example@3dworld.com', 'address'=> '123 Admin']);

        // Crear una estación de trabajo para la compañía "Admin"
        $adminWorkstation = Workstation::firstOrCreate([
            'name' => 'Admin Workstation',
            'company_id' => $adminCompany->id,
        ]);

        // Crear el usuario administrador
        $admin = User::updateOrCreate(
            ['email' => 'admin@3dworld.com'],
            [
                'name' => 'CastilloAdmin',
                'password' => bcrypt('contraseña'),
                'workstation_id' => $adminWorkstation->id,
            ]
        );

        // Asignar roles de administrador y jefe
        $admin->syncRoles([$adminRole, $bossRole]);
    }
}
