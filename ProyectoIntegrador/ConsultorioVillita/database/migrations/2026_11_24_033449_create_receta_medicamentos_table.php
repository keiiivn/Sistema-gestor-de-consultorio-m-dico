<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receta_medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id_receta_medicamento');
            $table->unsignedBigInteger('id_receta');
            $table->string('medicamento', 150);
            $table->string('presentacion', 100)->nullable();
            $table->string('dosis', 100)->nullable();
            $table->string('frecuencia', 100)->nullable();
            $table->string('duracion', 100)->nullable();
            $table->string('via_administracion', 50)->nullable();
            $table->text('indicaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_receta')
                ->references('id_receta')
                ->on('recetas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receta_medicamentos');
    }
};
