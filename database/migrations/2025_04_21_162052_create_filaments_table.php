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
        Schema::create('filaments', function (Blueprint $table) {
            $table->id();
            $table->string('material');
            $table->string('brand');
            $table->string('color');
            $table->float('diameter');
            $table->integer('weight');
            $table->integer('amount');

            $table->unsignedBigInteger('filament_user_id');
            $table->foreign('filament_user_id')->references('id')->on('workstations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filaments');
    }
};
