<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disciplina extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'nombre', 'descripcion', 'precio', 'id_seccion'];
    protected $table = 'DISCIPLINA';

    public function seccion():BelongsTo
    {
        return $this->belongsTo(Seccion::class);
    }
    
    public function grupos(): HasMany {
        return $this->hasMany(Grupo::class, 'id_disciplina');
    }

    public function paquetes():BelongsToMany {
        return $this->belongsToMany(Paquete::class, 'DISCIPLINA_PAQUETE', 'id_disciplina', 'id_paquete');
    }

}
