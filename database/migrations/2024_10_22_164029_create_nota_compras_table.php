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
        Schema::create('nota_compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(now('America/La_Paz', 'Y-m-d'));
            $table->time('hora')->default(now('America/La_Paz', 'H:i:s'));
            $table->decimal('total', 8, 2);
            $table->string('estado')->default('pendiente');

            $table->foreignId('proveedor_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_compras');
    }
};
