<?php

namespace App\Models;

use Database\Factories\EstudioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'id_paciente',
    'id_consulta',
    'nombre_archivo',
    'ruta_archivo',
    'tipo',
    'descripcion',
    'fecha_subida',
])]
class Estudio extends Model
{
    /** @use HasFactory<EstudioFactory> */
    use HasFactory;

    protected $table = 'estudios';

    protected $primaryKey = 'id_estudio';

    protected function casts(): array
    {
        return [
            'fecha_subida' => 'datetime',
        ];
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'id_consulta');
    }
}
