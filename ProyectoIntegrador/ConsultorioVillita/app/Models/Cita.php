<?php

namespace App\Models;

use Database\Factories\CitaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['id_paciente', 'id_medico', 'fecha', 'duracion_minutos', 'motivo', 'estado', 'observaciones'])]
class Cita extends Model
{
    /** @use HasFactory<CitaFactory> */
    use HasFactory;

    protected $table = 'citas';

    protected $primaryKey = 'id_cita';

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

    public function consulta(): HasOne
    {
        return $this->hasOne(Consulta::class, 'id_cita', 'id_cita');
    }

    public function scopeProximas(Builder $query): Builder
    {
        return $query->where('fecha', '>=', now())->orderBy('fecha');
    }

    public function scopeHoy(Builder $query): Builder
    {
        return $query->whereDate('fecha', today());
    }
}
