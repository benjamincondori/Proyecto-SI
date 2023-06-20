<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'cliente';
    protected $fillable = ['id', 'ci', 'nombres', 'apellidos', 'fecha_nacimiento', 'telefono', 'email', 'genero', 'fotografia', 'id_usuario'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function inscripciones(): HasMany {
        return $this->hasMany(Inscripcion::class, 'id_cliente');
    }

}
