<?php

namespace App\Models;

use Database\Factories\PacienteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

#[Fillable([
    'nombre',
    'fecha_nacimiento',
    'sexo',
    'telefono',
    'email',
    'direccion',
    'padecimiento',
    'alergias',
    'antecedentes',
    'fecha_registro',
    'ultima_consulta',
    'id_medico',
    'activo',
])]
class Paciente extends Model
{
    /** @use HasFactory<PacienteFactory> */
    use HasFactory;

    protected $table = 'pacientes';

    protected $primaryKey = 'id_paciente';

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_registro' => 'datetime',
            'ultima_consulta' => 'datetime',
            'activo' => 'boolean',
        ];
    }

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'id_medico', 'id_medico');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'id_paciente', 'id_paciente');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'id_paciente', 'id_paciente');
    }

    public function estudios(): HasMany
    {
        return $this->hasMany(Estudio::class, 'id_paciente', 'id_paciente');
    }

    public function recetas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Receta::class,
            Consulta::class,
            'id_paciente',
            'id_consulta',
            'id_paciente',
            'id_consulta'
        );
    }

    public function getEdadAttribute(): int
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    public function getInicialesAttribute(): string
    {
        $partes = preg_split('/\s+/', trim($this->nombre));

        $iniciales = collect($partes)->take(2)->map(
            fn (string $parte) => mb_strtoupper(mb_substr($parte, 0, 1))
        );

        return $iniciales->implode('');
    }
}
