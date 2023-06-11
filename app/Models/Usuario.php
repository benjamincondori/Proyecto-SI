<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'usuario';
    protected $fillable = ['id', 'usuario', 'contraseña', 'id_rol'];

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'id_usuario');
    }

    public function empleado(): HasOne
    {
        return $this->hasOne(Empleado::class, 'id_usuario');
    }

}
