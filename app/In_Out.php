<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class In_Out extends Model
{
    protected $table='in_outs';
    protected $fillable = [
        'id_producto',
        'tipo',
        'fecha',
        'cantidad',
        'costo_unitario',
        'costo_total',
    ]; 
    public $timestamps = false;
}
