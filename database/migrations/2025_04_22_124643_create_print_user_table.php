<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('print_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('printer_id')->constrained('printers')->onDelete('cascade');
        
            $table->string('name'); // nombre personalizado que el usuario da a esta impresora
            $table->enum('status', ['Available', 'On Use', 'Not Available'])->default('Available');
            $table->string('nozzle_size'); // puede ser texto o float, según tu necesidad
        
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('print_user');
    }
};
