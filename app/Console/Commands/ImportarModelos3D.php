<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Model3d;

class ImportarModelos3D extends Command
{
    protected $signature = 'importar:modelos';
    protected $description = 'Importar modelos 3D desde la API de Thingiverse';

    public function handle()
    {
        $this->info('Conectando a Thingiverse...');

        $token = '8e2e75bea461987a48de024c47e11d76'; // Tu App Token de Thingiverse

        $response = Http::withToken($token)->get('https://api.thingiverse.com/search/', [
            'q' => '3d printer',
            'page' => 1,
            'per_page' => 20,
        ]);

        if ($response->successful()) {
            $modelos = $response->json()['hits'];

            foreach ($modelos as $modelo) {
                Model3d::updateOrCreate(
                    [
                        'thingiverse_id' => $modelo['id'],
                    ],
                    [
                        'name' => $modelo['name'] ?? 'Sin nombre',
                        'description' => $modelo['description'] ?? '',
                        'author' => $modelo['creator']['name'] ?? 'Desconocido',
                        'url' => $modelo['public_url'] ?? '',
                        'image' => $modelo['thumbnail'] ?? '',
                        'file' => '',
                    ]
                );
            }

            $this->info('Modelos importados correctamente.');
        } else {
            $this->error('Error al conectar con la API de Thingiverse.');
        }
    }
}