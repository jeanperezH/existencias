<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\In_Out;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $ventas=In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('tipo','=','0')
            ->orderBy('in_outs.id','desc')->paginate(5);
        }else{
            $ventas=In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('tipo','=','0')
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')
            ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas'=>$ventas
        ];
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

                $salida = new In_Out();
                $salida->id_producto = $request->id_producto;
                $salida->tipo = '0';
                $salida->fecha = $request->fecha;
                $salida->cantidad = $request->cantidad;
                $salida->costo_unitario = $request->costo_unitario; 
                $salida->costo_total = $request->costo_total;          
                $salida->save();
  
    }
}
