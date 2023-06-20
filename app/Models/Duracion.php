<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Duracion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'nombre', 'dias_duracion'];
    protected $table = 'duracion';

    public function paquetes():BelongsToMany {
        return $this->belongsToMany(Paquete::class, 'paquete_duracion', 'id_duracion', 'id_paquete')->withPivot('precio', 'descuento');
    }

    public function inscripciones():BelongsToMany {
        return $this->belongsToMany(Inscripcion::class, 'id_duracion');
    }

}
