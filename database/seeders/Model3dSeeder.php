<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Model3d;

class Model3dSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ruta al archivo JSON
        $jsonPath = database_path('data/models.json');

        // Leer y decodificar el archivo JSON
        if (File::exists($jsonPath)) {
            $models = json_decode(File::get($jsonPath), true);

            foreach ($models as $modelData) {
                // Crear la carpeta para el modelo en public/models/{nombre_modelo}
                $destinationPath = public_path('models/' . $modelData['name']);
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Copiar el archivo STL al destino
                $stlSourcePath = database_path('data/models/' . $modelData['file']); // Cambiado a 'file'
                $stlDestinationPath = $destinationPath . '/' . $modelData['file']; // Cambiado a 'file'
                if (File::exists($stlSourcePath)) {
                    File::copy($stlSourcePath, $stlDestinationPath);
                } else {
                    $this->command->error("El archivo STL no existe: $stlSourcePath");
                }

                // Copiar la imagen al destino
                $imageSourcePath = database_path('data/models/' . $modelData['image']);
                $imageDestinationPath = $destinationPath . '/' . $modelData['image'];
                if (File::exists($imageSourcePath)) {
                    File::copy($imageSourcePath, $imageDestinationPath);
                } else {
                    $this->command->error("La imagen no existe: $imageSourcePath");
                }

                // Crear el modelo en la base de datos
                Model3d::create([
                    'name' => $modelData['name'],
                    'description' => $modelData['description'],
                    'author' => $modelData['author'],
                    'file' => 'models/' . $modelData['name'] . '/' . $modelData['file'], // Ruta completa del archivo STL
                    'image' => 'models/' . $modelData['name'] . '/' . $modelData['image'], // Ruta de la imagen
                ]);
            }
        } else {
            $this->command->error("The file models.json isn't in the route: $jsonPath");
        }
    }
}