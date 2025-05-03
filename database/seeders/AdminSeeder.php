<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Crear el usuario administrador
        $admin = User::create([
            'name' => 'CastilloAdmin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('contraseña'), // Cambia 'password' por una contraseña segura
        ]);

        // Asignar el rol de administrador
        $admin->assignRole('admin');
    }
}