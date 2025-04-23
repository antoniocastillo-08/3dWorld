<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Printer;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $printers = [
            [
                'name' => 'Ender 3',
                'model' => 'Ender',
                'type' => 'FDM',
                'brand' => 'Creality',
                'print_volume' => '220x220x250 mm',
                'status' => 'Available',
                'description' => 'Impresora 3D de alta precisión para principiantes.',
            ],
            [
                'name' => 'Ender 3 V3 SE',
                'model' => 'Ender',
                'type' => 'FDM',
                'brand' => 'Creality',
                'print_volume' => '220x220x250 mm',
                'status' => 'On Use',
                'description' => 'Impresora 3D de alta precisión para principiantes.',
            ],
            [
                'name' => 'Ender 3 V3 KE',
                'model' => 'Ender',
                'type' => 'FDM',
                'brand' => 'Creality',
                'print_volume' => '220x220x250 mm',
                'status' => 'Not Available',
                'description' => 'Impresora 3D de alta precisión para principiantes.',
            ],
            [
                'name' => 'Ultimaker S5',
                'model' => 'S5',
                'type' => 'FDM',
                'brand' => 'Ultimaker',
                'print_volume' => '330x240x300 mm',
                'status' => 'On Use',
                'description' => 'Impresora 3D profesional para prototipos industriales.',
            ],
            [
                'name' => 'Anycubic Photon Mono',
                'model' => 'Photon Mono',
                'type' => 'Resina',
                'brand' => 'Anycubic',
                'print_volume' => '130x80x165 mm',
                'status' => 'Not Available',
                'description' => 'Impresora 3D de resina para detalles finos.',
            ],
        ];

        foreach ($printers as $printer) {
            Printer::create($printer);
        }
    }
} 