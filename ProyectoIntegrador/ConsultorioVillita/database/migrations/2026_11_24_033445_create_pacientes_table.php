<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id_paciente');
            $table->string('nombre', 100);
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F']);
            $table->string('telefono', 20)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('padecimiento', 200)->nullable();
            $table->text('alergias')->nullable();
            $table->text('antecedentes')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->dateTime('ultima_consulta')->nullable();
            $table->unsignedBigInteger('id_medico')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('id_medico')
                ->references('id_medico')
                ->on('medicos')
                ->nullOnDelete();

            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
