<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->bigIncrements('id_receta');
            $table->unsignedBigInteger('id_consulta');
            $table->string('nombre_paciente', 100)->nullable();
            $table->unsignedSmallInteger('edad')->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->text('indicaciones')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->timestamps();

            $table->foreign('id_consulta')
                ->references('id_consulta')
                ->on('consultas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
