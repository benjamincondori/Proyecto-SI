<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion_Fisica extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'CONDICION_FISICA';
    protected $fillable = ['id', 'altura', 'peso', 'nivel', 'fecha', 'id_cliente'];

}
