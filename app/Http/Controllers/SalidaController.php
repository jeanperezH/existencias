<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salida;
use App\Informacion;
use App\Producto;

class SalidaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $salidas=Salida::join('productos','salidas.id_producto','=','productos.id')
            ->select('salidas.id','salidas.id_producto','productos.producto','salidas.fecha','salidas.tipo_comprobante','salidas.serie',
            'salidas.numero','salidas.tipo_operacion','salidas.cantidad',
            'salidas.costo_unitario','salidas.costo_total')
            ->orderBy('salidas.id','desc')->paginate(7);
        }else{
            $salidas=Salida::join('productos','salidas.id_producto','=','productos.id')
            ->select('salidas.id','salidas.id_producto','productos.producto','salidas.fecha','salidas.tipo_comprobante','salidas.serie',
            'salidas.numero','salidas.tipo_operacion','salidas.cantidad',
            'salidas.costo_unitario','salidas.costo_total')
            ->where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $salidas->total(),
                'current_page' => $salidas->currentPage(),
                'per_page'     => $salidas->perPage(),
                'last_page'    => $salidas->lastPage(),
                'from'         => $salidas->firstItem(),
                'to'           => $salidas->lastItem(),
            ],
            'salidas'=>$salidas
        ];
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $salidas = $request->data;//Array de salidas
            //Recorro todos los elementos

            foreach($salidas as $ep=>$det)
            {
                $salida = new Salida();
                $salida->id_producto = $det['id_producto'];
                $salida->fecha = $det['fecha'];
                $salida->tipo_comprobante = $det['tipo_comprobante'];
                $salida->serie = $det['serie'];
                $salida->numero = $det['numero'];
                $salida->tipo_operacion = $det['tipo_operacion'];
                $salida->cantidad = $det['cantidad'];
                $salida->costo_unitario = $det['costo_unitario']; 
                $salida->costo_total = $det['costo_total'];          
                $salida->save();
            }
        
    }
    
}
