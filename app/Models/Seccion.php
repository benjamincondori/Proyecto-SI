<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seccion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'seccion';
    protected $fillable = ['id', 'nombre', 'descripcion', 'capacidad'];

    public function disciplinas(): HasMany {
        return $this->hasMany(Disciplina::class, 'id_seccion');
    }
}
