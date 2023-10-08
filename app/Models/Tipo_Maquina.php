<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo_Maquina extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'TIPO_MAQUINA';
    protected $fillable = ['id', 'nombre', 'descripcion'];

    public function maquinas():HasMany {
        return $this->hasMany(Maquina::class, 'id_tipo');
    }

}
