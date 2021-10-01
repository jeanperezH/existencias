<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Salidas
                    <!--<button type="button" @click="abrirModal('producto','registrar')" class="btn btn-primary" >-->
                    <button type="button" @click="mostrarDetalle()" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                    </button>
                </div>
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <!-- Listado-->
                    <template v-if="listado">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="fecha">Fecha</option>
                                      <option value="tipo_comprobante">Tipo Comprobante</option>
                                      <option value="numero">Número</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarSalida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarSalida(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>fecha</th>
                                        <th>Tipo Comprobante</th>
                                        <th>Serie Comprobante</th>
                                        <th>Número Comprobante</th>
                                        <th>Tipo Operación</th>
                                        <th>Cantidad</th>
                                        <th>Costo Unitario (S/.)</th>
                                        <th>Costo Total (S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="salida in arraySalida" :key="salida.id">
                                        <td v-text="salida.id"></td>
                                        <td v-text="salida.producto"></td>
                                        <td v-text="salida.fecha"></td>
                                        <td v-text="salida.tipo_comprobante"></td>
                                        <td v-text="salida.serie"></td>
                                        <td v-text="salida.numero"></td>
                                        <td v-text="salida.tipo_operacion"></td>
                                        <td v-text="salida.cantidad"></td>
                                        <td v-text="salida.costo_unitario"></td>
                                        <td v-text="salida.costo_total"></td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else>
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto <span style="color:red;" v-show="id_producto==0">(*Seleccione)</span></label>
                                    <select class="form-control" v-model="id_producto" >
                                        <option v-for="productos in arrayProducto" :key="productos.id" :value="productos.id" v-text="productos.producto"></option>
                                    </select>                                     
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha<span style="color:red;" v-show="fecha==''">(*Seleccione)</span></label>
                                    <input type="date" class="form-control" v-model="fecha">                                     
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tipo Comprobante<span style="color:red;" v-show="tipo_comprobante==''">(*Seleccione)</span></label>
                                    <select class="form-control" v-model="tipo_comprobante">
                                        <option value="Factura">Factura</option>
                                        <option value="Recibo por Honorarios">Recibo por Honorarios</option>
                                        <option value="Boleta de Venta">Boleta de Venta</option>
                                        <option value="Liquidación de compra">Liquidación de compra</option>
                                        <option value="Boleto de compañia de aviación comercial por el servicio de transporte aéreo de pasajeros">Boleto de compañia de aviación comercial por el servicio de transporte aéreo de pasajeros</option>
                                        <option value="Carta de porte aéreo por el servicio de transporte de carga aérea">Carta de porte aéreo por el servicio de transporte de carga aérea</option>
                                        <option value="Nota de crédito">Nota de crédito</option>
                                        <option value="Nota de débito">Nota de débito</option>
                                        <option value="Guía de remisión - Remitente">Guía de remisión - Remitente</option>
                                        <option value="Recibo por arrendamiento">Recibo por arrendamiento</option>
                                        <option value="Póliza emitida por las bolsas de Valores, Bolsas de Productos o Agentes de Intermediación por operaciones realizadas en las Bolsas de Valores o Productos o fuera de las mismas, autorizadas por CONASEV">Póliza emitida por las bolsas de Valores, Bolsas de Productos o Agentes de Intermediación por operaciones realizadas en las Bolsas de Valores o Productos o fuera de las mismas, autorizadas por CONASEV</option>
                                        <option value="Ticket o cinta emitido por máquina registradora">Ticket o cinta emitido por máquina registradora</option>
                                        <option value="Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la Superintendencia de Banca y Seguros">Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la Superintendencia de Banca y Seguros</option>
                                        <option value="Recibo por servicios públicos de suministro de energía eléctrica, agua, teléfono, telex y telegráficos y otros servicios complementarios que se incluyan en el recibo de servicio público">Recibo por servicios públicos de suministro de energía eléctrica, agua, teléfono, telex y telegráficos y otros servicios complementarios que se incluyan en el recibo de servicio público</option>
                                        <option value="Boleto emitido por las empresas de transporte público urbano de pasajeros">Boleto emitido por las empresas de transporte público urbano de pasajeros</option>
                                        <option value="Boleto de viaje emitido por las empresas de transporte público interprovincial de pasajeros dentro del país">Boleto de viaje emitido por las empresas de transporte público interprovincial de pasajeros dentro del país</option>
                                        <option value="Documento emitido por la Iglesia Católica por el arrendamiento de bienes inmuebles">Documento emitido por la Iglesia Católica por el arrendamiento de bienes inmuebles</option>
                                        <option value="Documento emitido por las Administradoras Privadas de Fondo de Pensiones que se encuentran bajo la supervisión de la Superintendencia de Administradoras Privadas de Fondos de Pensiones">Documento emitido por las Administradoras Privadas de Fondo de Pensiones que se encuentran bajo la supervisión de la Superintendencia de Administradoras Privadas de Fondos de Pensiones</option>
                                        <option value="Boleto o entrada por atracciones y espectáculos públicos">Boleto o entrada por atracciones y espectáculos públicos</option>
                                        <option value="Comprobante de Retención">Comprobante de Retención</option>
                                        <option value="Conocimiento de embarque por el servicio de transporte de carga marítima">Conocimiento de embarque por el servicio de transporte de carga marítima</option>
                                        <option value="Comprobante por Operaciones No Habituales">Comprobante por Operaciones No Habituales</option>
                                        <option value="Pólizas de Adjudicación emitidas con ocasión del remate o adjudicación de bienes por venta forzada, por los martilleros o las entidades que rematen o subasten bienes por cuenta de terceros">Pólizas de Adjudicación emitidas con ocasión del remate o adjudicación de bienes por venta forzada, por los martilleros o las entidades que rematen o subasten bienes por cuenta de terceros</option>
                                        <option value="Certificado de pago de regalías emitidas por PERUPETRO S.A">Certificado de pago de regalías emitidas por PERUPETRO S.A</option>
                                        <option value="Documento de Atribución (Ley del Impuesto General a las Ventas e Impuesto Selectivo al Consumo, Art. 19º, último párrafo, R.S. N° 022-98-SUNAT).">Documento de Atribución (Ley del Impuesto General a las Ventas e Impuesto Selectivo al Consumo, Art. 19º, último párrafo, R.S. N° 022-98-SUNAT).</option>
                                        <option value="Recibo por el Pago de la Tarifa por Uso de Agua Superficial con fines agrarios y por el pago de la Cuota para la ejecución de una determinada obra o actividad acordada por la Asamblea General de la Comisión de Regantes o Resolución expedida por el Jefe de la Unidad de Aguas y de Riego (Decreto Supremo N° 003-90-AG, Arts. 28 y 48)">Recibo por el Pago de la Tarifa por Uso de Agua Superficial con fines agrarios y por el pago de la Cuota para la ejecución de una determinada obra o actividad acordada por la Asamblea General de la Comisión de Regantes o Resolución expedida por el Jefe de la Unidad de Aguas y de Riego (Decreto Supremo N° 003-90-AG, Arts. 28 y 48)</option>
                                        <option value="Seguro Complementario de Trabajo de Riesgo">Seguro Complementario de Trabajo de Riesgo</option>
                                        <option value="Tarifa Unificada de Uso de Aeropuerto">Tarifa Unificada de Uso de Aeropuerto</option>
                                        <option value="Documentos emitidos por la COFOPRI en calidad de oferta de venta de terrenos, los correspondientes a las subastas públicas y a la retribución de los servicios que presta">Documentos emitidos por la COFOPRI en calidad de oferta de venta de terrenos, los correspondientes a las subastas públicas y a la retribución de los servicios que presta</option>
                                        <option value="Documentos emitidos por las empresas que desempeñan el rol adquirente en los sistemas de pago mediante tarjetas de crédito y débito">Documentos emitidos por las empresas que desempeñan el rol adquirente en los sistemas de pago mediante tarjetas de crédito y débito</option>
                                        <option value="Guía de Remisión - Transportista">Guía de Remisión - Transportista</option>
                                        <option value="Documentos emitidos por las empresas recaudadoras de la denominada Garantía de Red Principal a la que hace referencia el numeral 7.6 del artículo 7° de la Ley N° 27133 – Ley de Promoción del Desarrollo de la Industria del Gas Natural">Documentos emitidos por las empresas recaudadoras de la denominada Garantía de Red Principal a la que hace referencia el numeral 7.6 del artículo 7° de la Ley N° 27133 – Ley de Promoción del Desarrollo de la Industria del Gas Natural</option>
                                        <option value="Documento del Operador">Documento del Operador</option>
                                        <option value="Documento del Partícipe">Documento del Partícipe</option>
                                        <option value="Recibo de Distribución de Gas Natural">Recibo de Distribución de Gas Natural</option>
                                        <option value="Documentos que emitan los concesionarios del servicio de revisiones técnicas vehiculares, por la prestación de dicho servicio">Documentos que emitan los concesionarios del servicio de revisiones técnicas vehiculares, por la prestación de dicho servicio</option>
                                        <option value="Declaración Única de Aduanas - Importación definitiva   ">Declaración Única de Aduanas - Importación definitiva   </option>
                                        <option value="Despacho Simplificado - Importación Simplificada">Despacho Simplificado - Importación Simplificada</option>
                                        <option value="Declaración de Mensajería o Courier">Declaración de Mensajería o Courier</option>
                                        <option value="Liquidación de Cobranza">Liquidación de Cobranza</option>
                                        <option value="Nota de Crédito Especial">Nota de Crédito Especial</option>
                                        <option value="Nota de Débito Especial">Nota de Débito Especial</option>
                                        <option value="Comprobante de No Domiciliado">Comprobante de No Domiciliado</option>
                                        <option value="Exceso de crédito fiscal por retiro de bienes  ">Exceso de crédito fiscal por retiro de bienes  </option>
                                        <option value="Nota de Crédito - No Domiciliado">Nota de Crédito - No Domiciliado</option>
                                        <option value="Nota de Débito - No Domiciliado">Nota de Débito - No Domiciliado</option>
                                        <option value="Otros -Consolidado de Boletas de Venta">Otros -Consolidado de Boletas de Venta</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie de Comprobante<span style="color:red;" v-show="serie==''">(*Ingrese)</span></label>
                                    <input type="text"  class="form-control" v-model="serie">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Numero de Comprobante<span style="color:red;" v-show="numero==''">(*Ingrese)</span></label>
                                    <input type="text"  class="form-control" v-model="numero">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Operación <span style="color:red;" v-show="tipo_operacion==''">(*Seleccione)</span></label>
                                    <select class="form-control" v-model="tipo_operacion">
                                        <option value="Venta">Venta</option>
                                        <option value="Compra">Compra</option>
                                        <option value="Consignación Recibida">Consignación Recibida</option>
                                        <option value="Consignación Entregada">Consignación Entregada</option>
                                        <option value="Devolución Recibida">Devolución Recibida</option>
                                        <option value="Devolución Entregada">Devolución Entregada</option>
                                        <option value="Promoción">Promoción</option>
                                        <option value="Premio">Premio</option>
                                        <option value="Donación">Donación</option>
                                        <option value="Salida a Producción">Salida a Producción</option>
                                        <option value="Transferencia entre almacenes">Transferencia entre almacenes</option>
                                        <option value="Retiro">Retiro</option>
                                        <option value="Mermas">Mermas</option>
                                        <option value="Desmedros">Desmedros</option>
                                        <option value="Destrucción">Destrucción</option>
                                        <option value="Saldo Inicial">Saldo Inicial</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>¿Tipo de cambio?</label> 
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label>No</label>
                            </div>
                            <div class="col-md-1">
                                <input type="radio" class="form-control" v-model="cambio" value=0>
                            </div>
                            <div class="col-md-10">  
                            </div>
                            <div class="col-md-1">
                                <label>Si</label>
                            </div>
                            <div class="col-md-1">
                                <input type="radio" class="form-control" v-model="cambio" value=1>
                            </div>
                            <div class="col-md-10">  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==''">(*Ingrese)</span></label>
                                    <input type="number" min="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Costo unitario <span style="color:red;" v-show="costo_unitario==''">(*Ingrese)</span></label>
                                    <input type="number" min="0" class="form-control" v-model="costo_unitario">
                                </div>
                            </div>
                            <div class="col-md-3">
                                
                                <div v-show="cambio=='1'" class="form-group">
                                    <label>Tipo de Cambio<span style="color:red;" v-show="tipo_cambio==''">(*Ingrese)</span></label>
                                    <input type="number" min="0" class="form-control" v-model="tipo_cambio">
                                </div>
                                
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="fas fa-plus-circle"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorEntrada" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEntrada" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            
                                            <th>Fecha</th>
                                            <th>Tipo Comprobante</th>
                                            <th>Serie Comprobante</th>
                                            <th>Número Comprobante</th>
                                            <th>Tipo Operación</th>
                                            <th>Cantidad</th>
                                            <th>Costo Unitario</th>
                                            <th>Costo Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.fecha">
                                            </td>
                                            <td>
                                                <input v-model="detalle.tipo_comprobante" type="text" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.serie" type="text" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.numero" type="text" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.tipo_operacion" type="text" class="form-control">
                                                <!--{{detalle.tipo_operacion}}-->
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.costo_unitario" type="number" class="form-control">
                                            </td>
                                            <td v-if="detalle.tipo_cambio==0">
                                                {{(detalle.costo_total=detalle.cantidad*detalle.costo_unitario).toFixed(2)}}
                                            </td>
                                            <td v-else>
                                                {{(detalle.costo_total=detalle.cantidad*detalle.costo_unitario*detalle.tipo_cambio).toFixed(2)}}
                                            </td>
                                        </tr>
                                        
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="7" align="right"><strong>Total:</strong></td>
                                            <td>$ {{costo_total_total=(calcularTotal).toFixed(2)}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="8">
                                                NO hay detalles agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarSalida()">Registrar Venta</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
        </main>
</template>

<script>
    
    export default {
        data (){
            return {
                salida_id: 0,
                id_producto:0,
                fecha : '',
                tipo_comprobante : 'Boleta de Venta',
                serie : '',
                numero: '',
                tipo_operacion: '',
                cantidad:0,
                costo_unitario:0.0,
                costo_total:0.0,
                costo_total_total:0.0,
                tipo_cambio:0.0,
                cambio:'0',
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arraySalida : [],
                arrayProducto: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEntrada : 0,
                errorMostrarMsjEntrada : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'fecha',
                buscar : '',

            }
        },
        
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var resultado=0.0;
                if(this.cambio=='0'){
                    for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].costo_unitario*this.arrayDetalle[i].cantidad)
                    }
                    return resultado;
                }else if(this.cambio=='1'){
                    for(var i=0;i<this.arrayDetalle.length;i++){
                        resultado=resultado+((this.arrayDetalle[i].costo_unitario)*(this.arrayDetalle[i].cantidad*this.arrayDetalle[i].tipo_cambio))
                    }
                    return resultado;
                }
                /*for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].costo_unitario*this.arrayDetalle[i].cantidad)
                    }
                    return resultado;*/
            }
        },
        methods : {
            listarSalida (page,buscar,criterio){
                let me=this;
                var url= '/Salida?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySalida = respuesta.salidas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarSalida(page,buscar,criterio);
            },
            agregarDetalle(){
                let me=this;
                if (this.validarEntrada()){
                    return;
                }else{
                    me.arrayDetalle.push({
                            id_producto: me.id_producto,
                            fecha: me.fecha,
                            tipo_comprobante: me.tipo_comprobante,
                            serie: me.serie,
                            numero: me.numero,
                            tipo_operacion: me.tipo_operacion,
                            cantidad: me.cantidad,
                            costo_unitario: me.costo_unitario,
                            tipo_cambio:me.tipo_cambio,
                            costo_total: me.costo_total
                        });
                       
                        me.fecha="";
                        me.tipo_comprobante="Boleta de Venta";
                        me.serie="";
                        me.numero="";
                        me.tipo_operacion="";
                        me.cantidad=0;
                        me.costo_unitario=0.0; 
                        me.tipo_cambio=0.0;
                        me.costo_total=0.0;
                        //me.cambio='0';
                }
                       
            },
            cargarPdf(){
                window.open('http://localhost:8000/Entrada/listarPdf','_blank');
            },
            selectProducto(){
                let me = this;
                var url='/Producto/selectProducto';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayProducto=respuesta.productos;
                    
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            registrarSalida(){
                
                let me = this;

                axios.post('/Salida/registrar',{
                    'id_producto': this.id_producto,
                    'fecha': this.fecha,
                    'tipo_comprobante' : this.tipo_comprobante,
                    'serie' : this.serie,
                    'numero' : this.numero,
                    'tipo_operacion' : this.tipo_operacion,
                    'cantidad' : this.cantidad,
                    'costo_unitario' : this.costo_unitario,
                    'costo_total' : this.costo_total,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarSalida(1,'','fecha');
                    
                    me.fecha="";
                    me.tipo_comprobante="Boleta de Venta";
                    me.serie="";
                    me.numero="";
                    me.tipo_operacion="";
                    me.cantidad=0;
                    me.costo_unitario=0.0; 
                    me.costo_total=0.0;
                    me.id_producto=0;
                    me.tipo_cambio=0.0;
                    me.arrayDetalle=[];

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarEntrada(){
                this.errorEntrada=0;
                this.errorMostrarMsjEntrada =[];

                if (this.id_producto==0) this.errorMostrarMsjEntrada.push("Seleccione un Producto");
                if (!this.fecha) this.errorMostrarMsjEntrada.push("Ingrese la fecha");
                if (this.tipo_comprobante=='') this.errorMostrarMsjEntrada.push("Seleccione el tipo comprobante");
                if (!this.serie) this.errorMostrarMsjEntrada.push("Ingrese la serie del comprobante");
                if (!this.numero) this.errorMostrarMsjEntrada.push("Ingrese el número de comprobante");
                if (!this.cantidad) this.errorMostrarMsjEntrada.push("Ingrese la cantidad");
                if (!this.costo_unitario) this.errorMostrarMsjEntrada.push("Ingrese el costo unitario");
                //if (this.arrayDetalle.length<=0) this.errorMostrarMsjEntrada.push("Ingrese detalles");

                if (this.errorMostrarMsjEntrada.length) this.errorEntrada = 1;

                return this.errorEntrada;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.id_producto=0;
                me.fecha='';
                me.tipo_comprobante='Boleta de Venta';
                me.serie='';
                me.numero='';
                me.tipo_operacion='';
                me.cantidad=0;
                me.costo_unitario=0.0;
                me.costo_total=0.0;
                me.arrayDetalle=[];

                me.selectProducto();
            },
            ocultarDetalle(){
                
                let me=this;
                me.listado=1;

                me.id_producto=0;
                me.fecha='';
                me.tipo_comprobante='Boleta de Venta';
                me.serie='';
                me.numero='';
                me.tipo_operacion='';
                me.cantidad=0;
                me.costo_unitario=0.0;
                me.costo_total=0.0;
                me.arrayDetalle=[];
                me.errorEntrada=0;
            },
            
            
        },
        mounted() {
            this.listarSalida(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
