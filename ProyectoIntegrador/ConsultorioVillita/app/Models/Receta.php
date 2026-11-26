<?php

namespace App\Models;

use Database\Factories\RecetaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'id_consulta',
    'nombre_paciente',
    'edad',
    'altura',
    'peso',
    'indicaciones',
])]
class Receta extends Model
{
    /** @use HasFactory<RecetaFactory> */
    use HasFactory;

    protected $table = 'recetas';

    protected $primaryKey = 'id_receta';

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'datetime',
            'altura' => 'decimal:2',
            'peso' => 'decimal:2',
        ];
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'id_consulta', 'id_consulta');
    }

    public function medicamentos(): HasMany
    {
        return $this->hasMany(RecetaMedicamento::class, 'id_receta', 'id_receta');
    }
}
