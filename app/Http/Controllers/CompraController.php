<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Compra;
use App\In_Out;

class CompraController extends Controller
{
    public function index1(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $compras=Compra::join('productos','compras.id_producto','=','productos.id')
            ->select('compras.id','compras.id_producto','productos.producto','compras.fecha','compras.cantidad',
            'compras.costo_unitario','compras.costo_total')
            ->orderBy('compras.fecha','desc')->paginate(5);
        }else{
            $compras=Compra::join('productos','compras.id_producto','=','productos.id')
            ->select('compras.id','compras.id_producto','productos.producto','compras.fecha','compras.cantidad',
            'compras.costo_unitario','compras.costo_total')
            ->where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('compras.fecha','desc')
                                ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $compras->total(),
                'current_page' => $compras->currentPage(),
                'per_page'     => $compras->perPage(),
                'last_page'    => $compras->lastPage(),
                'from'         => $compras->firstItem(),
                'to'           => $compras->lastItem(),
            ],
            'compras'=>$compras
        ];
        
    }
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $compras=In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('tipo','=','1')
            ->orderBy('in_outs.id','desc')->paginate(5);
        }else{
            $compras=In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('tipo','=','1')
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('in_outs.id','desc')
            ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $compras->total(),
                'current_page' => $compras->currentPage(),
                'per_page'     => $compras->perPage(),
                'last_page'    => $compras->lastPage(),
                'from'         => $compras->firstItem(),
                'to'           => $compras->lastItem(),
            ],
            'compras'=>$compras
        ];
        
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

                $entrada = new In_Out();
                $entrada->id_producto = $request->id_producto;
                $entrada->tipo = '1';
                $entrada->fecha = $request->fecha;
                $entrada->cantidad = $request->cantidad;
                $entrada->costo_unitario = $request->costo_unitario; 
                $entrada->costo_total = $request->costo_total;          
                $entrada->save();
  
    }
}
