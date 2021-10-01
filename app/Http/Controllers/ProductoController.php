<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\In_Out;
//use App\Informacion;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $productos=Producto::orderBy('id','desc')->paginate(4);
        }else{
            $productos=Producto::where($criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos'=>$productos
        ];
        
    }

    public function selectProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $productos = Producto::select('id','producto')->orderBy('producto','asc')->get();
        return ['productos'=>$productos];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $productos = new Producto();
            $productos->producto=$request->producto;
            $productos->save();

            $compras=new In_Out();
            $compras->id_producto=$productos->id;
            $compras->tipo = '1';
            $compras->fecha = $request->fecha;
            $compras->cantidad = $request->cantidad;
            $compras->costo_unitario = $request->costo_unitario;
            $compras->costo_total = $request->costo_total;
            
            $compras->save();
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }
        
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $productos = Producto::findOrFail($request->id);
        $productos->producto=$request->producto;
        //$productos->stock=$request->stock;
        $productos->save();
    }
    public function listarPdf(){
        $productos=Producto::orderBy('id','desc')->get();
        $cont=Producto::count();
        //$pdf=\PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont])->setPaper('a4', 'landscape'); //horizontal
        $pdf=\PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont]);
        return $pdf->stream('productos.pdf');
    }
    public function fifoMetodo(){
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
