<template>
    <main class="main">
    
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Pedidos
                <button type="button" @click="abrirModal('pedido','registrar')" class="btn btn-primary" >
                    <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th colspan="3"><span style="color:blue;"><center>KPI</center></span></th>
                            <th colspan="7"><span style="color:blue;"><center>DATOS</center></span></th>
                        </tr>
                        <tr>
                            
                            <th><center>Calidad pedidos generados</center></th>
                            <th><center>Volumen de compra</center></th>
                            <th><center>Entregas perfectamente recibidas</center></th>
                            <th>Mes</th>
                            <th>Pedidos</th>
                            <th>Total de pedidos</th>
                            <th>Valor de compra</th>
                            <th>Total de ventas</th>
                            <th>Pedidos rechazados</th>
                            <th>Total de órdenes de compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pedido in arrayPedidos" :key="pedido.id">
                            
                            <td>
                                <center>
                                    <button type="button" @click="verKPI('pedido','kpi11',pedido)" class="btn btn-info btn-sm" >
                                        <i class="fas fa-eye"></i>
                                    </button> &nbsp;
                                </center>
                            </td>
                            <td>
                                <center>
                                    <button type="button" @click="verKPI('pedido','kpi12',pedido)" class="btn btn-info btn-sm" >
                                        <i class="fas fa-eye"></i>
                                    </button> &nbsp;
                                </center>
                            </td>
                            <td>
                                <center>
                                    <button type="button" @click="verKPI('pedido','kpi13',pedido)" class="btn btn-info btn-sm" >
                                        <i class="fas fa-eye"></i>
                                    </button> &nbsp;
                                </center>
                            </td>
                            <td v-text="pedido.mes"></td>
                            <td v-text="pedido.pedidos"></td>
                            <td v-text="pedido.total_pedidos"></td>
                            <td v-text="pedido.valor_compra"></td>
                            <td v-text="pedido.total_ventas"></td>
                            <td v-text="pedido.pedidos_rechazados"></td>
                            <td v-text="pedido.total_ordenes_compra"></td>
                        </tr>
                        
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item " v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>
                        
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>               
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>

    <!--Inicio del modal registrar/actualizar-->
    <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h4 class="modal-title" v-text="tituloModal"></h4></center>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Mes<span style="color:red;" v-show="mes==''">(*Seleccione)</span></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="mes" >
                                    <option value="Enero">Enero</option>
                                    <option value="Febrero">Febrero</option>
                                    <option value="Marzo">Marzo</option>
                                    <option value="Abril">Abril</option>
                                    <option value="Mayo">Mayo</option>
                                    <option value="Junio">Junio</option>
                                    <option value="Julio">Julio</option>
                                    <option value="Agosto">Agosto</option>
                                    <option value="Setiembre">Setiembre</option>
                                    <option value="Octubre">Octubre</option>
                                    <option value="Noviembre">Noviembre</option>
                                    <option value="Diciembre">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Pedidos <span style="color:red;" v-show="pedidos==''">(*Ingrese)</span></label>
                            <div class="col-md-9">
                                <input type="number" v-model="pedidos" class="form-control" placeholder="100...0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Total de pedidos <span style="color:red;" v-show="total_pedidos==''">(*Ingrese)</span></label>
                            <div class="col-md-9">
                                <input type="number" v-model="total_pedidos" class="form-control" placeholder="100...0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Valor de compra (S/.) <span style="color:red;" v-show="valor_compra==''">(*Ingrese)</span></label>
                            <div class="col-md-9">
                                <input type="number" v-model="valor_compra" class="form-control" placeholder="S/.1000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Total de ventas (S/.) <span style="color:red;" v-show="total_ventas==''">(*Ingrese)</span></label>
                            <div class="col-md-9">
                                <input type="number" v-model="total_ventas" class="form-control" placeholder="S/.1000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Pedidos rechazados <span style="color:red;" v-show="pedidos_rechazados==''">(*Ingrese)</span></label>
                            <div class="col-md-9">
                                <input type="number" v-model="pedidos_rechazados" class="form-control" placeholder="n">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Total de órdenes de compra <span style="color:red;" v-show="total_ordenes_compra==''">(*Ingrese)</span></label>
                            <div class="col-md-9">
                                <input type="number" v-model="total_ordenes_compra" class="form-control" placeholder="nn">
                            </div>
                        </div>
                        
                        <div v-show="errorPedido" class="form-group row" div-error >   
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPedido" :key="error" v-text="error">
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPedido()">Guardar</button>
                    
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal KPI11-->
    <div class="modal fade"  tabindex="-1" :class="{'mostrarKPI' : modalKPI11}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <th colspan="4"><span style="color:blue;">Formula:</span></th>
                            <tr>
                                <th colspan="4">
                                    <img src="img/KPI11.jpg" width="100%">
                                </th>
                            </tr>
                            <tr><th colspan="4"><span style="color:blue;">Datos:</span></th></tr>
                            <tr>
                                <th>Mes</th>
                                <th>Pedidos generados sin problemas</th>
                                <th>Total de pedidos</th>
                                <th>KPI (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in arrayPedidos" :key="pedido.id">
                                <td v-text="pedido.mes"></td>
                                <td v-text="pedido.pedidos"></td>
                                <td v-text="pedido.total_pedidos"></td>
                                <td v-text="Math.round((pedido.pedidos/pedido.total_pedidos)*100)+'%'"></td>
                            </tr>                          
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item " v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

    <!--Inicio del modal KPI12-->
    <div class="modal fade"  tabindex="-1" :class="{'mostrarKPI' : modalKPI12}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <th colspan="4"><span style="color:blue;">Formula:</span></th>
                            <tr>
                                <th colspan="4">
                                    <img src="img/KPI12.jpg" width="100%">
                                </th>
                            </tr>
                            <tr><th colspan="4"><span style="color:blue;">Datos:</span></th></tr>
                            <tr>
                                <th>Mes</th>
                                <th>Valor de compra</th>
                                <th>Total de ventas</th>
                                <th>KPI (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in arrayPedidos" :key="pedido.id">
                                <td v-text="pedido.mes"></td>
                                <td v-text="pedido.valor_compra"></td>
                                <td v-text="pedido.total_ventas"></td>
                                <td v-text="Math.round((pedido.valor_compra/pedido.total_ventas)*100)+'%'"></td>
                            </tr>                          
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item " v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    
    <!--Inicio del modal KPI12-->
    <div class="modal fade"  tabindex="-1" :class="{'mostrarKPI' : modalKPI13}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <th colspan="4"><span style="color:blue;">Formula:</span></th>
                            <tr>
                                <th colspan="4">
                                    <img src="img/KPI13.jpg" width="100%">
                                </th>
                            </tr>
                            <tr><th colspan="4"><span style="color:blue;">Datos:</span></th></tr>
                            <tr>
                                <th>Mes</th>
                                <th>Pedidos rechazados</th>
                                <th>Total de órdenes de compra</th>
                                <th>KPI (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in arrayPedidos" :key="pedido.id">
                                <td v-text="pedido.mes"></td>
                                <td v-text="pedido.pedidos_rechazados"></td>
                                <td v-text="pedido.total_ordenes_compra"></td>
                                <td v-text="Math.round((pedido.pedidos_rechazados/pedido.total_ordenes_compra)*100)+'%'"></td>
                            </tr>                          
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item " v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
</main>
</template>

<script>
    export default {
        props : ['ruta'],
        data(){
            return{
                pedido_id:0,
                mes : '',
                pedidos : '',
                total_pedidos : '',
                valor_compra : '',
                total_ventas : '',
                pedidos_rechazados : '',
                total_ordenes_compra : '',
                
                arrayPedidos:[],
                arrayKPI11:[],
                arrayKPI12:[],
                arrayKPI13:[],
                modal : 0,
                modalKPI11:0,
                modalKPI12:0,
                modalKPI13:0,
                tituloModal :'',
                tipoAccion:0,
                errorPedido:0,
                errorMostrarMsjPedido:[],
                pagination :{
                    'total' :0,
                    'current_page' :0,
                    'per_Page' :0,
                    'last_page' :0,
                    'from' :0,
                    'to' :0,
                },
                offset:3,
                criterio: '',
                buscar:''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elementos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to){return [];}
                var from = this.pagination.current_page - this.offset;
                if(from<1){
                    from=1;
                }
                var to = from + (this.offset * 2);
                if(to >=this.pagination.last_page){
                    to=this.pagination.last_page;
                }
                var pagesArrary=[];
                while(from<=to){
                    pagesArrary.push(from);
                    from++;
                }
                return pagesArrary;
            }
        },
        methods: {
            listarPedido(page,buscar,criterio){
                let me = this;
                var url=this.ruta + '/Pedido?page=' + page+'&buscar=' +buscar+'&criterio='+criterio;
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayPedidos=respuesta.pedidos.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //
                me.listarPedido(page,buscar,criterio);
                
            },
            registrarPedido(){
                if(this.validarPedido()){
                    return;
                }

                let me = this;
                axios.post(me.ruta + '/Pedido/registrar' ,{
                    'mes':me.mes,
                    'pedidos':me.pedidos,
                    'total_pedidos':me.total_pedidos,
                    'valor_compra':me.valor_compra,
                    'total_ventas':me.total_ventas,
                    'pedidos_rechazados':me.pedidos_rechazados,
                    'total_ordenes_compra':me.total_ordenes_compra,
                    
                }).then(function(response){
                    me.cerrarModal();
                    
                    me.listarPedido(1,'','');
                }).catch(function(error){
                    console.log(error);
                })
            },
            
            validarPedido(){
                this.errorPedido=0;
                this.errorMostrarMsjPedido=[];
                if(!this.mes) this.errorMostrarMsjPedido.push("Seleccione mes");
                if(!this.pedidos) this.errorMostrarMsjPedido.push("Ingrese pedidos");
                if(!this.total_pedidos) this.errorMostrarMsjPedido.push("Ingrese total de pedidos");
                if(!this.valor_compra) this.errorMostrarMsjPedido.push("Ingrese valor de compra");
                if(!this.total_ventas) this.errorMostrarMsjPedido.push("Ingrese total de ventas");
                if(!this.pedidos_rechazados) this.errorMostrarMsjPedido.push("Ingrese pedidos rechazados");
                if(!this.total_ordenes_compra) this.errorMostrarMsjPedido.push("Ingrese total de ordenes de compra");
                if(this.errorMostrarMsjPedido.length) this.errorPedido=1;
                return this.errorPedido;
            },
            
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "pedido":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tituloModal='Registar Nuevo pedido';
                                this.mes='';
                                this.pedidos='';
                                this.total_pedidos='';
                                this.valor_compra='';
                                this.total_ventas='';
                                this.pedidos_rechazados='';
                                this.total_ordenes_compra='';
                                this.tipoAccion=1;
                                break;
                            }
                            
                        }
                    }
                }
            },
            verKPI(modelo, accion, data=[]){
                switch(modelo){
                    case "pedido":{
                        switch(accion){
                            case 'kpi11':{
                                this.modalKPI11=1;
                                this.tituloModal='Ver KPI Calidad de pedidos generados';
                                this.pedido_id=data['id'];
                                this.mes=data['mes'];
                                this.pedidos=data['pedidos'];
                                this.total_pedidos=data['total_pedidos'];
                                break;
                            }
                            case 'kpi12':{
                                this.modalKPI12=1;
                                this.tituloModal='Ver KPI Volumen de compra';
                                this.pedido_id=data['id'];
                                this.mes=data['mes'];
                                this.valor_compra=data['valor_compra'];
                                this.total_ventas=data['total_ventas'];
                                break;
                            }
                            case 'kpi13':{
                                this.modalKPI13=1;
                                this.tituloModal='Ver KPI Entregas perfectamente recibidas';
                                this.pedido_id=data['id'];
                                this.mes=data['mes'];
                                this.pedidos_rechazados=data['pedidos_rechazados'];
                                this.total_ordenes_compra=data['total_ordenes_compra'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.modalKPI11=0;
                this.modalKPI12=0;
                this.modalKPI13=0;
                this.tituloModal='';
                this.mes='';
                this.pedidos='';
                this.total_pedidos='';
                this.valor_compra='';
                this.total_ventas='';
                this.pedidos_rechazados='';
                this.total_ordenes_compra='';
                this.tipoAccion=0;
            }
        },
        mounted() {
            this.listarPedido(1,this.buscar,this.criterio);
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
    .mostrarKPI{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #030303af !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red;
        font-weight: bold;
    }
</style>
