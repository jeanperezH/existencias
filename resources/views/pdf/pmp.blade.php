<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte método PMP</title>
    <style>
        body {
        
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 10px;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 10%;
        font-size: 15px;
        
        }

        section{
        clear: left;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 11px;
        }

        #totalFooter{
            background: #2183E3;
            color: #FFFFFF;
            font-size: 11px;
        }
        
        #outs{
            background: #f5d9d9;
            
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #texto-final{
        text-align: left; 
        }
    </style>
    <body>
        @foreach ($producto as $prod)
            <header>
                <div id="datos">
                    <p id="encabezado">
                        <b>{{$prod->producto}}</b>
                    </p>
                </div>
            </header>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facarticulo" border="1">
                    <thead>
                        <tr id="fa">
                            <th colspan="10">MÉTODO PRECIO MEDIO PONDERADO</th>
                        </tr>
                        <tr id="fa">
                            <th rowspan="2">FECHA</th>
                            <th colspan="3">COMPRAS</th>
                            <th colspan="3">VENTAS</th>
                            <th colspan="3">EXISTENCIAS</th>
                        </tr>
                        <tr id="fa">
                            <!--<th>FECHA</th>-->
                            <th>UNIDADES</th>
                            <th>PRECIO DE COMPRA</th>
                            <th>COSTO TOTAL</th>
                            <th>UNIDADES</th>
                            <th>PMP</th>
                            <th>COSTO TOTAL</th>
                            <th>UNIDADES</th>
                            <th>PMP</th>
                            <th>COSTO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sub_t_cant=0;
                            $sub_t_cost=0;
                            $sub_t_cost_v=0;
                            $pmp=0;
                            $cost_tot_existencia_in=0;
                            $cost_tot_existencia_out=0;
                            $cant_tot_existencia_in=0;
                            $cant_tot_existencia_out=0;
                        @endphp
                        @foreach ($in_outs as $in)
                        <tr align="center">
                            
                            @if ($in->tipo == 1)
                                <td>{{$in->fecha}}</td>

                                <td>{{$in->cantidad}}</td>
                                <td>S/. {{$in->costo_unitario}}</td>
                                <td>S/. {{$in->costo_total}}</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                @php
                                    if ($pmp==0) {
                                        $pmp = $in->costo_unitario; 
                                    } else {
                                        $pmp = round((($sub_t_cant * $pmp)+($in->cantidad * $in->costo_unitario))/($sub_t_cant+$in->cantidad),2);
                                    }
                                    $sub_t_cant += $in->cantidad;
                                    $sub_t_cost = $sub_t_cant * $pmp; 
                                    
                                @endphp

                                <td>{{$sub_t_cant}}</td>
                                <td>S/. {{$pmp}}</td>
                                <td>S/. {{$sub_t_cost}}</td>
                                @php
                                    $cost_tot_existencia_in+=$sub_t_cost;
                                    $cant_tot_existencia_in+=$sub_t_cant;
                                @endphp
                                                                
                            @else
                                <td id="outs">{{$in->fecha}}</td>

                                <td id="outs"></td>
                                <td id="outs"></td>
                                <td id="outs"></td>

                                @php
                                    $sub_t_cant = $sub_t_cant - $in->cantidad;
                                    $sub_t_cost = $sub_t_cant * $pmp;
                                    
                                @endphp
                                
                                <td id="outs">{{$in->cantidad}}</td>
                                <td id="outs">S/. {{$pmp}}</td>
                                <td id="outs">S/. {{$in->cantidad * $pmp}}</td>
                                
                                
                                <td id="outs">{{$sub_t_cant}}</td>
                                <td id="outs">S/. {{$pmp}}</td>
                                <td id="outs">S/. {{$sub_t_cost}}</td>
                                @php
                                    $sub_t_cost_v+=($in->cantidad * $pmp);
                                    $cost_tot_existencia_out+=$sub_t_cost;
                                    $cant_tot_existencia_out+=$sub_t_cant;
                                @endphp
                            @endif
                            
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        @php
                            $cantidad_total_c=0;
                            $costo_total_total_c=0;

                            $cantidad_total_v=0;
                            $costo_total_total_v=0.0;

                            $cantidad_total_t=0;
                            $costo_unitario_total_t=0;
                            $costo_total_total_t=0.0;

                            

                        @endphp
                        @foreach ($in_outs as $in)
                            @php
                                if ($in->tipo==1) {
                                    $cantidad_total_c+=$in->cantidad;
                                    $costo_total_total_c+=$in->costo_total;
                                }elseif ($in->tipo==0) {
                                    $cantidad_total_v+=$in->cantidad;
                                    $costo_total_total_v+=($in->cantidad * $pmp);
                                }
                            @endphp
                        @endforeach

                        <tr id="totalFooter" align="center" >
                            <th>TOTAL</th>
                            <td>{{$cantidad_total_c}}</td>
                            <td></td>
                            <td> S/. {{$costo_total_total_c}}</td>

                            <td>{{$cantidad_total_v}}</td>
                            <td></td>
                            <td> S/. {{$sub_t_cost_v}}</td>

                            <td>{{($cant_tot_existencia_in + $cant_tot_existencia_out)}}</td>
                            <td></td>
                            <td> S/. {{$cost_tot_existencia_in + $cost_tot_existencia_out}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="texto-final">
                <p><b>Valoración de existencias por el método PMP</b></p>
            </div>
        </footer>
    </body>
</html>