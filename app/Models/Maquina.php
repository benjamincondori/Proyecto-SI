<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maquina extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'MAQUINA';
    protected $fillable = ['codigo', 'estado', 'id_seccion', 'id_tipo'];

    public function seccion(): BelongsTo {
        return $this->belongsTo(Seccion::class, 'id_seccion');
    }

    public function tipo(): BelongsTo {
        return $this->belongsTo(Tipo_Maquina::class, 'id_tipo');
    }

}
