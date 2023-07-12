<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ASISTENCIA';
    protected $fillable = ['id', 'fecha_de_ingreso', 'hora_de_ingreso', 'id_cliente', 'id_administrativo'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function administrativo(): BelongsTo {
        return $this->belongsTo(Administrativo::class, 'id_administrativo');
    }

}
