<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entrada;
use App\Salida;
use App\Informacion;
use App\Producto;

class EntradaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $entradas=Entrada::join('productos','entradas.id_producto','=','productos.id')
            ->select('entradas.id','entradas.id_producto','productos.producto','entradas.fecha','entradas.tipo_comprobante','entradas.serie',
            'entradas.numero','entradas.tipo_operacion','entradas.cantidad',
            'entradas.costo_unitario','entradas.costo_total')
            ->orderBy('entradas.id','desc')->paginate(7);
        }else{
            $entradas=Entrada::join('productos','entradas.id_producto','=','productos.id')
            ->select('entradas.id','entradas.id_producto','productos.producto','entradas.fecha','entradas.tipo_comprobante','entradas.serie',
            'entradas.numero','entradas.tipo_operacion','entradas.cantidad',
            'entradas.costo_unitario','entradas.costo_total')
            ->where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $entradas->total(),
                'current_page' => $entradas->currentPage(),
                'per_page'     => $entradas->perPage(),
                'last_page'    => $entradas->lastPage(),
                'from'         => $entradas->firstItem(),
                'to'           => $entradas->lastItem(),
            ],
            'entradas'=>$entradas
        ];
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $entradas = $request->data;//Array de entradas
            //Recorro todos los elementos

            foreach($entradas as $ep=>$det)
            {
                $entrada = new Entrada();
                $entrada->id_producto = $det['id_producto'];
                $entrada->fecha = $det['fecha'];
                $entrada->tipo_comprobante = $det['tipo_comprobante'];
                $entrada->serie = $det['serie'];
                $entrada->numero = $det['numero'];
                $entrada->tipo_operacion = $det['tipo_operacion'];
                $entrada->cantidad = $det['cantidad'];
                $entrada->costo_unitario = $det['costo_unitario']; 
                $entrada->costo_total = $det['costo_total'];          
                $entrada->save();
            }
        
    }
    public function listarPdf(Request $request,$id){
        $informaciones = Informacion::join('productos','informaciones.id_producto','=','productos.id')
            ->select('informaciones.id','informaciones.id_producto','productos.producto','informaciones.periodo','informaciones.ruc','informaciones.apellidos_nombres_dr',
            'informaciones.establecimiento','informaciones.codigo_existencia','informaciones.tipo_existencia',
            'informaciones.descripcion','informaciones.unidad_medida','informaciones.metodo_valuacion')
            ->where('informaciones.id_producto','=',$id)
            ->orderBy('informaciones.id','asc')->get();

        $entradas=Entrada::join('productos','entradas.id_producto','=','productos.id')
            ->select('entradas.id','entradas.id_producto','productos.producto','entradas.fecha','entradas.tipo_comprobante','entradas.serie',
            'entradas.numero','entradas.tipo_operacion','entradas.cantidad',
            'entradas.costo_unitario','entradas.costo_total')
            ->where('entradas.id_producto','=',$id)
            ->orderBy('entradas.fecha','asc')->get();

        $salidas_p=Salida::join('productos','salidas.id_producto','=','productos.id')
            ->select('salidas.id','salidas.id_producto','productos.producto','salidas.fecha','salidas.tipo_comprobante','salidas.serie',
            'salidas.numero','salidas.tipo_operacion','salidas.cantidad',
            'salidas.costo_unitario','salidas.costo_total')
            ->where('salidas.id_producto','=',$id)
            ->orderBy('salidas.fecha','asc')->get();

        $producto=Producto::select('producto')->where('id',$id)->get();
        $fecha_actual=now();
        //$cont=Entrada::count();
        $pdf=\PDF::loadView('pdf.entradaspdf',['informaciones'=>$informaciones,'entradas'=>$entradas,'salidas_p'=>$salidas_p])->setPaper('a4', 'landscape');
        //return $pdf->stream('Reporte-'.$numero_entrada[0]->numero.'.pdf');
        return $pdf->stream($producto[0]->producto.'-reporte-'.$fecha_actual.'.pdf');
    }
}
