<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permiso extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'PERMISO';
    protected $fillable = ['id', 'nombre'];

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Rol::class, 'ROL_PERMISO', 'id_permiso', 'id_rol');
    }

}
