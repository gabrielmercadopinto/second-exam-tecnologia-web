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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(now('America/La_Paz', 'Y-m-d'));
            $table->date('fecha_limite');
            $table->decimal('total', 8, 2);
            // $table->string('estado')->default('pendiente');
            // referencia a la tabla users

            $table->foreignId('user_id')->constrained();
            $table->foreignId('cliente_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacions');
    }
};
