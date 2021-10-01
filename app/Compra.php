<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
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
