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
        Schema::create('filament_printer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('printer_id')->constrained('printers')->onDelete('cascade');
            $table->foreignId('filament_id')->constrained('filaments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filament_printer');
    }
};
