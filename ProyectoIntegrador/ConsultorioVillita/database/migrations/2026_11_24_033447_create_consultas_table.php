<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->bigIncrements('id_consulta');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_medico')->nullable();
            $table->unsignedBigInteger('id_cita')->nullable()->unique();
            $table->dateTime('fecha')->useCurrent();
            $table->text('motivo');
            $table->text('antecedentes')->nullable();
            $table->text('signos_vitales')->nullable();
            $table->text('revision_fisica')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('resultados')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')
                ->references('id_paciente')
                ->on('pacientes')
                ->cascadeOnDelete();

            $table->foreign('id_medico')
                ->references('id_medico')
                ->on('medicos')
                ->nullOnDelete();

            $table->foreign('id_cita')
                ->references('id_cita')
                ->on('citas')
                ->nullOnDelete();

            $table->index('fecha');
            $table->index('id_paciente');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
