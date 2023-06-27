<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casillero extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'nro', 'tamaño', 'precio', 'estado'];
    protected $table = 'CASILLERO';

}
