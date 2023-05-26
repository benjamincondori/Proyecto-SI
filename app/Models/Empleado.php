<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'empleado';
    protected $fillable = ['id', 'ci', 'nombres', 'apellidos', 'fecha_nacimiento', 'direccion', 'telefono', 'email', 'genero', 'turno', 'fotografia', 'tipo_empleado', 'id_usuario'];

    public function administrativos(): HasMany {
        return $this->hasMany(Administrativo::class, 'id');
    }
}
