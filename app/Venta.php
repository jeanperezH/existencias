<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'id_producto',
        'fecha',
        'cantidad',
        'costo_unitario',
        'costo_total',
    ]; 
    public $timestamps = false;
}
