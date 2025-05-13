<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('print_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('printer_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Available', 'On Use', 'Not Available'])->default('Available');
            $table->float('nozzle_size')->nullable();
            // $table->float('print_speed')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('print_user');
    }
};
