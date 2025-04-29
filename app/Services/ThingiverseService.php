<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ThingiverseService
{
    protected $baseUrl = 'https://api.thingiverse.com';

    /**
     * Realiza una búsqueda de modelos en Thingiverse.
     *
     * @param string $query
     * @return array|null
     */
    public function searchModels(string $query): ?array
    {
        $response = Http::withToken(config('services.thingiverse.app_token'))
            ->get("{$this->baseUrl}/search", [
                'q' => $query,
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Obtiene los detalles de un modelo específico por su ID.
     *
     * @param string $thingId
     * @return array|null
     */
    public function getModelDetails(string $thingId): ?array
    {
        $response = Http::withToken(config('services.thingiverse.app_token'))
            ->get("{$this->baseUrl}/things/{$thingId}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}