<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Model3d;

class ImportarModelos3D extends Command
{
    protected $signature = 'importar:modelos';
    protected $description = 'Importar modelos 3D desde la API de Thingiverse';

    public function handle()
    {
        $this->info('Conectando a Thingiverse...');

        $token = config('services.thingiverse.app_token');
        $page = 1; // Solo la primera página
        $perPage = 20; // Número de modelos por página
        $totalModels = 0;

        $this->info("Obteniendo modelos de la página $page...");

        $response = Http::withToken($token)->get('https://api.thingiverse.com/search/', [
            'q' => '3d printer',
            'page' => $page,
            'per_page' => $perPage,
        ]);

        if ($response->successful()) {
            $modelos = $response->json()['hits'];

            // Limitar a los primeros 10 modelos
            $modelos = array_slice($modelos, 0, 10);

            foreach ($modelos as $modelo) {
                // Guardar metadatos en la base de datos
                $model = Model3d::updateOrCreate(
                    [
                        'thingiverse_id' => $modelo['id'],
                    ],
                    [
                        'name' => $modelo['name'] ?? 'Sin nombre',
                        'description' => $modelo['description'] ?? '',
                        'author' => $modelo['creator']['name'] ?? 'Desconocido',
                        'url' => $modelo['public_url'] ?? '',
                        'image' => $modelo['thumbnail'] ?? '',
                        'file' => '', // Se actualizará después de descargar los archivos
                    ]
                );

                // Crear una carpeta para el modelo
                $folderName = "models/{$modelo['id']}";
                Storage::disk('public')->makeDirectory($folderName);

                // Descargar los archivos STL (si están disponibles)
                $thingId = $modelo['id'];
                $detailsResponse = Http::withToken($token)->get("https://api.thingiverse.com/things/{$thingId}");

                if ($detailsResponse->successful()) {
                    $details = $detailsResponse->json();
                    if (isset($details['files_url'])) {
                        $filesResponse = Http::withToken($token)->get($details['files_url']);
                        if ($filesResponse->successful()) {
                            $files = $filesResponse->json();
                            foreach ($files as $file) {
                                if (str_ends_with($file['name'], '.stl')) {
                                    $this->info("Descargando archivo STL: {$file['name']}...");

                                    // Descargar el archivo STL usando streams
                                    $stlResponse = Http::withToken($token)->get($file['download_url'], ['stream' => true]);
                                    if ($stlResponse->successful()) {
                                        $filePath = "{$folderName}/{$file['name']}";
                                        $stream = $stlResponse->toPsrResponse()->getBody();
                                        Storage::disk('public')->put($filePath, $stream);
                                    }
                                }
                            }
                        }
                    }
                }

                // Actualizar la ruta de la carpeta en la base de datos
                $model->update(['file' => $folderName]);
            }

            $totalModels += count($modelos);
        } else {
            $this->error('Error al conectar con la API de Thingiverse.');
        }

        $this->info("Importación completada. Total de modelos importados: $totalModels.");
    }
}