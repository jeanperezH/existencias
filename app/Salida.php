<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $fillable = [
        'id_producto',
        'fecha',
        'tipo_comprobante',
        'serie',
        'numero',
        'tipo_operacion',
        'cantidad',
        'costo_unitario',
        'costo_total',
    ]; 
    public $timestamps = false;
}
