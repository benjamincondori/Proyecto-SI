<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'horario';
    protected $fillable = ['id', 'descripcion', 'hora_inicio', 'hora_fin'];

    public function grupos(): HasMany {
        return $this->hasMany(Grupo::class, 'id_horario');
    }
}
