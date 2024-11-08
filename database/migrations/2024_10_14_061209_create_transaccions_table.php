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
        Schema::create('transaccions', function (Blueprint $table) {
            $table->id();
            $table->integer('transaccion');
            $table->string('fecha_generada')->default(now('America/La_Paz')->format('Y-m-d H:i:s'));
            $table->string('fecha_pagada')->nullable();
            $table->string('fecha_validez')->nullable();
            //numero chico, binario o caracter para el estado
            $table->integer('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccions');
    }
};
