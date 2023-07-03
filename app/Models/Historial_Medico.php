<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Historial_Medico extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'HISTORIAL_MEDICO';
    protected $fillable = ['id', 'enfermedades', 'id_cliente'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

}
