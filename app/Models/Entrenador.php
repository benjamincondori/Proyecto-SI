<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entrenador extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'especialidad'];
    protected $table = 'ENTRENADOR';

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Entrenador::class, 'id');
    } 

    public function grupos(): HasMany {
        return $this->hasMany(Grupo::class, 'id_entrenador');
    }

}
