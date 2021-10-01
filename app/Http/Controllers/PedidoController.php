<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $pedidos=Pedido::orderBy('id','asc')->paginate(4);
        }else{
            $pedidos=Pedido::where($criterio,'like','%'.$buscar.'%')
                            ->orderBy('id','asc')
                            ->paginate(3);
        }

        return[
            'pagination' => [
                'total'        => $pedidos->total(),
                'current_page' => $pedidos->currentPage(),
                'per_page'     => $pedidos->perPage(),
                'last_page'    => $pedidos->lastPage(),
                'from'         => $pedidos->firstItem(),
                'to'           => $pedidos->lastItem(),
            ],
            'pedidos'=>$pedidos
        ];
        
    }
    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');

        $pedidos = new Pedido();
        $pedidos->mes = $request->mes;
        $pedidos->pedidos = $request->pedidos;
        $pedidos->total_pedidos = $request->total_pedidos;
        $pedidos->valor_compra = $request->valor_compra;
        $pedidos->total_ventas = $request->total_ventas; 
        $pedidos->pedidos_rechazados = $request->pedidos_rechazados;   
        $pedidos->total_ordenes_compra = $request->total_ordenes_compra;          
        $pedidos->save();   
    }

}
