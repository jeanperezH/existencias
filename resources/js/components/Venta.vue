<template>
            <main class="main">
            <!-- Breadcrumb -->
            
            <div class="container-fluid">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Ventas
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
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarSalida(1,buscar,criterio)" class="form-control" placeholder="aaaa-mm-dd">
                                    <button type="submit" @click="listarSalida(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Vender</th>
                                        <th>Producto</th>
                                        <th>fecha</th>
                                        <th>Cantidad</th>
                                        <th>Costo Unitario (S/.)</th>
                                        <th>Costo Total (S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="salida in arraySalida" :key="salida.id">
                                        <td>
                                            <center>
                                                <button type="button" @click="venderEspecífico('salida','elegir',salida)" class="btn btn-success btn-sm" >
                                                    <i class="fas fa-plus-circle"></i>
                                                </button> &nbsp; 
                                            </center>                               
                                        </td>
                                        <td v-text="salida.producto"></td>
                                        <td v-text="salida.fecha"></td>
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
                            <div class="col-md-12">
                                <button type="button" class="close" @click="ocultarDetalle()" aria-label="Close">
                                    <span span style="color:red;" aria-hidden="true">x</span>
                                </button>
                            </div>
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
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==''">(*Ingrese)</span></label>
                                    <input type="number" min="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Costo unitario (S/.) <span style="color:red;" v-show="costo_unitario==''">(*Ingrese)</span></label>
                                    <input type="number" min="0" class="form-control" v-model="costo_unitario">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Costo total <span style="color:red;" v-show="costo_total==''">(*)</span></label>
                                    <td>
                                        S/. {{(costo_total=cantidad*costo_unitario).toFixed(2)}}
                                    </td>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div v-show="errorSalida" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSalida" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
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
        props : ['ruta'],
        data (){
            return {
                salida_id: 0,
                id_producto:0,
                fecha : '',
                cantidad:0,
                costo_unitario:0.0,
                costo_total:0.0,
                //costo_total_total:0.0,
                //tipo_cambio:0.0,
                //cambio:'0',
                //totalImpuesto: 0.0,
                //totalParcial: 0.0,
                arraySalida : [],
                arrayProducto: [],
                arrayDetalle : [],
                listado:1,
                
                errorSalida : 0,
                errorMostrarMsjSalida : [],
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
                var url=this.ruta + '/Venta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySalida = respuesta.ventas.data;
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
                if (this.validarSalida()){
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
                var url=this.ruta + '/Producto/selectProducto';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayProducto=respuesta.productos;
                    
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            registrarSalida(){
                if (this.validarSalida()){
                    return;
                }else{
                    let me = this;

                    axios.post(this.ruta + '/Venta/registrar',{
                        'id_producto': this.id_producto,
                        'fecha': this.fecha,
                        'cantidad' : this.cantidad,
                        'costo_unitario' : this.costo_unitario,
                        'costo_total' : this.costo_total,
                        //'data': this.arrayDetalle

                    }).then(function (response) {
                        me.listado=1;
                        me.listarSalida(1,'','fecha');
                        
                        me.ocultarDetalle();
                        me.arrayDetalle=[];

                    }).catch(function (error) {
                        console.log(error);
                    });
                }
                
            },
            validarSalida(){
                this.errorSalida=0;
                this.errorMostrarMsjSalida =[];

                if (this.id_producto==0) this.errorMostrarMsjSalida.push("Seleccione un Producto");
                if (!this.fecha) this.errorMostrarMsjSalida.push("Ingrese la fecha");
                if (!this.cantidad) this.errorMostrarMsjSalida.push("Ingrese la cantidad");
                if (!this.costo_unitario) this.errorMostrarMsjSalida.push("Ingrese el costo unitario");
                //if (this.arrayDetalle.length<=0) this.errorMostrarMsjSalida.push("Ingrese detalles");

                if (this.errorMostrarMsjSalida.length) this.errorSalida = 1;

                return this.errorSalida;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.salida_id=0;
                me.fecha='';
                me.cantidad=0;
                me.costo_unitario=0.0;
                me.costo_total=0.0;
                //me.arrayDetalle=[];

                me.selectProducto();

                me.selectProducto();
            },
            venderEspecífico(modelo, accion, data=[]){
                let me=this;
                switch(modelo){
                    case "salida":{
                        switch(accion){
                            case 'elegir':{
                                me.listado=0;
                                me.salida_id=0;
                                me.id_producto=data['id_producto'];
                                me.fecha='';
                                me.cantidad=0;
                                me.costo_unitario=0.0;
                                me.costo_total=0.0;
                                
                                break;
                            }
                        }
                    }
                }

                me.selectProducto();
            },
            ocultarDetalle(){
                let me=this;
                me.listado=1;

                me.entrada_id=0;
                me.id_producto=0;
                me.fecha='';
                me.cantidad=0;
                me.costo_unitario=0.0;
                me.costo_total=0.0;
                //me.arrayDetalle=[];
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
