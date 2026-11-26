<?php

namespace App\Models;

use Database\Factories\MedicoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id_usuario', 'cedula', 'especialidad', 'telefono', 'consultorio', 'biografia', 'activo'])]
class Medico extends Model
{
    /** @use HasFactory<MedicoFactory> */
    use HasFactory;

    protected $table = 'medicos';

    protected $primaryKey = 'id_medico';

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function pacientes(): HasMany
    {
        return $this->hasMany(Paciente::class, 'id_medico', 'id_medico');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'id_medico', 'id_medico');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'id_medico', 'id_medico');
    }

    public function getNombreAttribute(): string
    {
        return $this->usuario?->nombre ?? 'Médico sin nombre';
    }
}
