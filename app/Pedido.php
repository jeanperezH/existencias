<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table='pedidos';
    protected $fillable = [
        'mes',
        'pedidos',
        'total_pedidos',
        'valor_compra',
        'total_ventas',
        'pedidos_rechazados',
        'total_ordenes_compra',
    ]; 
    public $timestamps = false;
}
