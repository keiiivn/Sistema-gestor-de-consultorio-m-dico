<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudios', function (Blueprint $table) {
            $table->bigIncrements('id_estudio');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->string('nombre_archivo', 255);
            $table->string('ruta_archivo', 255);
            $table->string('tipo', 80)->nullable();
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_subida')->useCurrent();
            $table->timestamps();

            $table->foreign('id_paciente')
                ->references('id_paciente')
                ->on('pacientes')
                ->cascadeOnDelete();

            $table->foreign('id_consulta')
                ->references('id_consulta')
                ->on('consultas')
                ->nullOnDelete();

            $table->index('fecha_subida');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudios');
    }
};
