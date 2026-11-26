<?php

namespace App\Models;

use Database\Factories\ConsultaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'id_paciente',
    'id_medico',
    'id_cita',
    'fecha',
    'motivo',
    'antecedentes',
    'signos_vitales',
    'revision_fisica',
    'diagnostico',
    'tratamiento',
    'resultados',
    'notas',
])]
class Consulta extends Model
{
    /** @use HasFactory<ConsultaFactory> */
    use HasFactory;

    protected $table = 'consultas';

    protected $primaryKey = 'id_consulta';

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'id_medico', 'id_medico');
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'id_cita', 'id_cita');
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class, 'id_consulta', 'id_consulta');
    }

    public function estudios(): HasMany
    {
        return $this->hasMany(Estudio::class, 'id_consulta', 'id_consulta');
    }
}
