<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id_cita');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_medico')->nullable();
            $table->dateTime('fecha');
            $table->unsignedSmallInteger('duracion_minutos')->default(30);
            $table->string('motivo', 255)->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'atendida'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')
                ->references('id_paciente')
                ->on('pacientes')
                ->cascadeOnDelete();

            $table->foreign('id_medico')
                ->references('id_medico')
                ->on('medicos')
                ->nullOnDelete();

            $table->index('fecha');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
