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
        Schema::create('nota_ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(now('America/La_Paz', 'Y-m-d'));
            $table->time('hora')->default(now('America/La_Paz', 'H:i:s'));
            $table->decimal('total', 8, 2);
            $table->decimal('descuento', 8, 2)->default(0);
            $table->string('estado')->default('pendiente');

            $table->foreignId('cliente_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('metodo_pago_id')->constrained();
            $table->foreignId('transaccion_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_ventas');
    }
};
