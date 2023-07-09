<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'FACTURA';
    protected $fillable = ['id', 'fecha_emision', 'descripcion', 'monto_total', 'NIT', 'id_pago'];

    public function pago(): BelongsTo {
        return $this->belongsTo(Pago::class, 'id_pago');
    }

}
