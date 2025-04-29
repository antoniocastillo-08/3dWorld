<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('model3ds', function (Blueprint $table) {
            $table->id();
            $table->string('thingiverse_id')->unique(); // ID del modelo en Thingiverse
            $table->string('name');
            $table->text('description')->nullable(); // Cambiar a text para descripciones largas
            $table->string('author')->nullable(); // Autor del modelo
            $table->string('file')->nullable(); // Ruta al archivo descargado
            $table->string('image')->nullable(); // Imagen del modelo
            $table->string('url')->nullable(); // URL del modelo en Thingiverse
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model3ds');
    }
};
