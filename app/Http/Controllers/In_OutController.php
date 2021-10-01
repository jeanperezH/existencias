<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\In_Out;
use App\Producto;

class In_OutController extends Controller
{
    public function index(Request $request)
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
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

                $entrada = new Compra();
                $entrada->id_producto = $request->id_producto;
                $entrada->fecha = $request->fecha;
                $entrada->cantidad = $request->cantidad;
                $entrada->costo_unitario = $request->costo_unitario; 
                $entrada->costo_total = $request->costo_total;          
                $entrada->save();
  
    }
    public function metodoPMP1(Request $request,$id){
        $compras = In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('in_outs.tipo','=','1')
            ->where('in_outs.id_producto','=',$id)
            ->orderBy('in_outs.id','asc')->get();

        $ventas = In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('in_outs.tipo','=','0')
            ->where('in_outs.id_producto','=',$id)
            ->orderBy('in_outs.id','asc')->get();

        $producto=Producto::select('producto')->where('id',$id)->get();
        $fecha_actual=now();
        //$cont=Entrada::count();
        $pdf=\PDF::loadView('pdf.pmp',['compras'=>$compras,'ventas'=>$ventas,'producto'=>$producto])->setPaper('a4', 'landscape');
        //return $pdf->stream('Reporte-'.$numero_entrada[0]->numero.'.pdf');
        return $pdf->stream($producto[0]->producto.'-reporte-'.$fecha_actual.'.pdf');
    }
    public function metodoPMP(Request $request,$id){
        $in_outs = In_Out::join('productos','in_outs.id_producto','=','productos.id')
            ->select('in_outs.id','in_outs.id_producto','productos.producto','in_outs.tipo','in_outs.fecha','in_outs.cantidad',
            'in_outs.costo_unitario','in_outs.costo_total')
            ->where('in_outs.id_producto','=',$id)
            ->orderBy('in_outs.id','asc')->get();

        $producto=Producto::select('producto')->where('id',$id)->get();
        $fecha_actual=now();
        //$cont=Entrada::count();
        $pdf=\PDF::loadView('pdf.pmp',['in_outs'=>$in_outs,'producto'=>$producto])->setPaper('a4', 'landscape');
        //return $pdf->stream('Reporte-'.$numero_entrada[0]->numero.'.pdf');
        return $pdf->stream('Reporte-'.$producto[0]->producto.'-PMP-'.$fecha_actual.'.pdf');
    }
}
