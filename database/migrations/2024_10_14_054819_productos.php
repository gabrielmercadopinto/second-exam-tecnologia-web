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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_oem');
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->string('unidad');
            $table->string('clasificacion_abc')->nullable();
            $table->string('ubicacion');
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo');
            $table->boolean('estado')->default(true);

            //relaciones
            $table->foreignId('marca_id')->constrained();
            $table->foreignId('categoria_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
