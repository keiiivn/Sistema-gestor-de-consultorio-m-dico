<?php

namespace App\Models;

use Database\Factories\RecetaMedicamentoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'id_receta',
    'medicamento',
    'presentacion',
    'dosis',
    'frecuencia',
    'duracion',
    'via_administracion',
    'indicaciones',
])]
class RecetaMedicamento extends Model
{
    /** @use HasFactory<RecetaMedicamentoFactory> */
    use HasFactory;

    protected $table = 'receta_medicamentos';

    protected $primaryKey = 'id_receta_medicamento';

    public function receta(): BelongsTo
    {
        return $this->belongsTo(Receta::class, 'id_receta', 'id_receta');
    }
}
