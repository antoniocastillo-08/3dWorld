<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Model3d;

class Model3dSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el modelo Benchy
        Model3d::create([
            'name' => 'Benchy',
            'description' => 'El 3D Benchy es un modelo de prueba diseñado para evaluar la precisión y calidad de impresión 3D.',
            'file' => 'models/benchy.stl', // Ruta del archivo STL
            'image' => 'images/benchy.jpg', // Ruta de la imagen de vista previa
        ]);
    }
}