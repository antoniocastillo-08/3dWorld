<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Printer;
use Illuminate\Support\Facades\File;
class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Ruta al archivo JSON
    $jsonPath = database_path('data/printers.json');

    // Leer y decodificar el archivo JSON
    if (File::exists($jsonPath)) {
      $printers = json_decode(File::get($jsonPath), true);

      // Insertar cada impresora en la base de datos
      foreach ($printers as $printer) {
          Printer::create($printer);
      }
    } else {
      $this->command->error("The file printers.json isn't in the route: $jsonPath");
    }
    }
} 