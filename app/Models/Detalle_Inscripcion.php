<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detalle_Inscripcion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'detalle_inscripcion';
    protected $fillable = ['id', 'fecha_inicio', 'fecha_vencimiento', 'dias_restantes', 'estado', 'id_paquete', 'id_inscripcion'];

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class, 'id_inscripcion');
    }

}
