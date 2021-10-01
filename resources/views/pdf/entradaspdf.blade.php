<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Inventario</title>
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

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 15px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 80%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 9px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
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
        @foreach ($informaciones as $inf)
        <header>
            <div id="datos">
                <p id="encabezado">
                    <b>{{$inf->producto}}</b>
                </p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">FORMATO 13.1: "REGISTRO DE INVENTARIO PERMANENTE VALORIZADO - DETALLE DEL INVENTARIO VALORIZADO"</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">PERIODO: {{$inf->periodo}}<br>
                            RUC: {{$inf->ruc}}<br>
                            APELLIDOS Y NOMBRES, DENOMINACIÓN O RAZÓN SOCIAL: {{$inf->apellidos_nombres_dr}}<br>
                            ESTABLECIMIENTO: {{$inf->establecimiento}}<br>
                            CÓDIGO DE LA EXISTENCIA: {{$inf->codigo_existencia}}<br>
                            TIPO: {{$inf->tipo_existencia}}<br>
                            DESCRIPCIÓN: {{$inf->descripcion}}<br>
                            CÓDIGO DE LA UNIDAD DE MEDIDA: {{$inf->unidad_medida}}<br>
                            MÉTODO DE VALUACIÓN: {{$inf->metodo_valuacion}}</</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facarticulo" border="1">
                    <thead>
                        <tr id="fa">
                            <th colspan="4">DOCUMENTO DE TRASLADO, COMPROBANTE DE PAGO, DOCUMENTO INTERNO O SIMILAR </th>
                            <th></th>
                            <th colspan="3">ENTRADAS</th>
                            <th colspan="3">SALIDAS</th>
                            <th colspan="3">SALDO FINAL</th>
                        </tr>
                        <tr id="fa">
                            <th>FECHA</th>
                            <th>TIPO</th>
                            <th>SERIE</th>
                            <th>NÚMERO</th>
                            <th>TIPO DE OPERACIÓN</th>
                            <th>CANTIDAD</th>
                            <th>COSTO UNITARIO</th>
                            <th>COSTO TOTAL</th>
                            <th>CANTIDAD</th>
                            <th>COSTO UNITARIO</th>
                            <th>COSTO TOTAL</th>
                            <th>CANTIDAD</th>
                            <th>COSTO UNITARIO</th>
                            <th>COSTO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entradas as $ent)
                        <tr align="center">
                            <td>{{$ent->fecha}}</td>
                            <td>{{$ent->tipo_comprobante}}</td>
                            <td>{{$ent->serie}}</td>
                            <td>{{$ent->numero}}</td>
                            <td>{{$ent->tipo_operacion}}</td>
                            <td>{{$ent->cantidad}}</td>
                            <td>S/. {{$ent->costo_unitario}}</td>
                            <td>S/. {{$ent->costo_total}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$ent->cantidad}}</td>
                            <td>S/. {{$ent->costo_unitario}}</td>
                            <td>S/. {{$ent->costo_total}}</td>
                            <!--<td>{{$ent->cantidad*$ent->precio-$ent->descuento}}</td>-->
                        </tr>
                        @endforeach
                        @foreach ($salidas_p as $sal)
                        <tr align="center">
                            <td>{{$sal->fecha}}</td>
                            <td>{{$sal->tipo_comprobante}}</td>
                            <td>{{$sal->serie}}</td>
                            <td>{{$sal->numero}}</td>
                            <td>{{$sal->tipo_operacion}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$sal->cantidad}}</td>
                            <td>S/. {{$sal->costo_unitario}}</td>
                            <td>S/. {{$sal->costo_total}}</td>
                            
                            <td>{{$sal->cantidad}}</td>
                            <td>S/. {{$sal->costo_unitario}}</td>
                            <td>S/. {{$sal->costo_total}}</td>
                            <!--<td>{{$ent->cantidad*$ent->precio-$ent->descuento}}</td>-->
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $cantidad_total_e=0;
                            $costo_unitario_total_e=0;
                            $costo_total_total_e=0;

                            $cantidad_total_s=0;
                            $costo_unitario_total_s=0;
                            $costo_total_total_s=0;

                            $cantidad_total_t=0;
                            $costo_unitario_total_t=0;
                            $costo_total_total_t=0

                        @endphp
                        @foreach ($entradas as $ent)
                            @php
                                $cantidad_total_e+=$ent->cantidad;
                                $costo_unitario_total_e+=$ent->costo_unitario;
                                $costo_total_total_e+=$ent->costo_total;
                            @endphp
                        @endforeach
                        @foreach ($salidas_p as $sal)
                            @php
                                $cantidad_total_s+=$sal->cantidad;
                                $costo_unitario_total_s+=$sal->costo_unitario;
                                $costo_total_total_s+=$sal->costo_total;
                            @endphp
                        @endforeach

                        <tr align="center" >
                            <th colspan="5" >TOTAL</th>
                            <td>{{$cantidad_total_e}}</td>
                            <td></td>
                            <!--<td>S/. {{$costo_unitario_total_e}}</td>-->
                            <td> S/. {{$costo_total_total_e}}</td>

                            <td>{{$cantidad_total_s}}</td>
                            <td></td>
                            <!--<td>S/. {{$costo_unitario_total_s}}</td>-->
                            <td> S/. {{$costo_total_total_s}}</td>

                            <td>{{($cantidad_total_e - $cantidad_total_s)}}</td>
                            <td></td>
                            <!--<td>S/. {{$costo_unitario_total_e - $costo_unitario_total_s}}</td>-->
                            <td> S/. {{ $costo_total_total_e - $costo_total_total_s}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="texto-final">
                <p><b>Dirección del Establecimiento o Código según el Registro Único de Contribuyentes.</b></p>
            </div>
        </footer>
    </body>
</html>