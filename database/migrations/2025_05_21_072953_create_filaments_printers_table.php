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
        Schema::create('filaments_printers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('printer_user_id');
            $table->unsignedBigInteger('filament_user_id');
            $table->timestamps();

            $table->foreign('printer_user_id')->references('id')->on('print_users')->onDelete('cascade');
            $table->foreign('filament_user_id')->references('id')->on('filaments')->onDelete('cascade');

            $table->unique(['printer_user_id', 'filament_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filaments_printers');
    }
};
