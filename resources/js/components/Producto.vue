<template>
    <main class="main">
    
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Productos
                <!--<button type="button" @click="abrirModal('producto','registrar')" class="btn btn-primary" >-->
                <button type="button" @click="mostrarDetalle()" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                </button>
                <button type="button" @click="cargarPdf()" class="btn btn-info">
                    <i class="fas fa-file-pdf"></i>&nbsp;Reporte
                </button>
            </div>
            <template v-if="listado">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio" >
                              <option value="producto">Producto</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="producto a buscar" >
                            <button type="submit" class="btn btn-primary" @click="listarProducto(1,buscar,criterio)" ><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <!--<th colspan="4"><span style="color:blue;">Opciones</span></th>-->
                            <th colspan="4"><span style="color:blue;"><center>OPCIONES</center></span></th>
                            <th rowspan="2"><span style="color:blue; margin:10px; padding:10px;"><center>PRODUCTOS</center></span></th>
                        </tr>
                        <tr>
                            <th><center>Editar</center></th>
                            <th><center>FIFO</center></th>
                            <th><center>LIFO</center></th>
                            <th><center>PMP</center></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in arrayProducto" :key="producto.id">
                            <td>
                                <center>
                                    <button type="button" @click="abrirModal('producto','actualizar',producto)" class="btn btn-warning btn-sm" >
                                        <i class="fas fa-pen-alt"></i>
                                    </button> &nbsp; 
                                </center>                               
                            </td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-info btn-sm" >
                                        <i class="fas fa-file-pdf"></i>
                                    </button> &nbsp;
                                </center>
                            </td>
                            <td>
                                <center>
                                    <button type="button" class="btn btn-info btn-sm" >
                                        <i class="fas fa-file-pdf"></i>
                                    </button> &nbsp;
                                </center>
                            </td>
                            <td>
                                <center>
                                    <button type="button" @click="ReportePMP_pdf(producto.id)" class="btn btn-success btn-sm" >
                                        <i class="fas fa-file-pdf"></i>
                                    </button> &nbsp;
                                </center>
                            </td>
                            <td v-text="producto.producto"></td>
                            <!--<td v-text="producto.stock"></td>-->
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
            </template>
            <!-- Registrar nuevo producto-->
            <template v-else-if="listado==0">
                <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-12">
                                <button type="button" class="close" @click="ocultarDetalle()" aria-label="Close">
                                    <span span style="color:red;" aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for=""><h5>Registro de nuevo producto</h5></label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Producto <span style="color:red;" v-show="producto==''">(*Ingrese)</span></label>
                                    <input type="text" class="form-control" v-model="producto">
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for=""><h5>Existencia Inicial</h5></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha<span style="color:red;" v-show="fecha==''">(*Seleccione)</span></label>
                                    <input type="date" class="form-control" v-model="fecha">                                     
                                </div>
                            </div>
                            <div class="col-md-8">
                            
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==''">(*Ingrese)</span></label>
                                    <input type="number" min="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Costo adquisición (S/.) <span style="color:red;" v-show="costo_unitario==''">(*Ingrese)</span></label>
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
                                <div v-show="errorProducto" class="form-group row" div-error >   
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-danger">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarProducto()">Registrar</button>
                            </div>
                        </div>
                </div>
            </template>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                            <div class="col-md-9">
                                <input type="text" v-model="producto" class="form-control" placeholder="Producto">
                                
                            </div>
                        </div>
                        
                        <div v-show="errorProducto" class="form-group row" div-error >   
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProducto()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProducto()">Actualizar</button>
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
                producto_id:0,
                producto : '',
                //stock : 0,
                fecha: '',
                cantidad:0,
                costo_unitario:0.0,
                costo_total:0.0,
                arrayProducto:[],
                listado:1,
                modal : 0,
                tituloModal :'',
                tipoAccion:0,
                errorProducto:0,
                errorMostrarMsjProducto:[],
                pagination :{
                    'total' :0,
                    'current_page' :0,
                    'per_Page' :0,
                    'last_page' :0,
                    'from' :0,
                    'to' :0,
                },
                offset:3,
                criterio: 'producto',
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
            listarProducto(page,buscar,criterio){
                let me = this;
                var url=this.ruta + '/Producto?page=' + page+'&buscar=' +buscar+'&criterio='+criterio;
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayProducto=respuesta.productos.data;
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
                me.listarProducto(page,buscar,criterio);
                
            },
            registrarProducto(){
                if(this.validarProducto()){
                    return;
                }

                let me = this;
                axios.post(this.ruta + '/Producto/registrar' ,{
                    'producto':this.producto,

                    'fecha':this.fecha,
                    'cantidad':this.cantidad,
                    'costo_unitario':this.costo_unitario,
                    'costo_total':this.costo_total,
                    
                }).then(function(response){
                    me.cerrarModal();
                    me.ocultarDetalle();
                    me.listarProducto(1,'','producto');
                }).catch(function(error){
                    console.log(error);
                })
            },
            ReportePMP_pdf(id){
                window.open(this.ruta + '/In_Out/metodoPMP/'+ id +','+'_blank');
            },
            cargarPdf(){
                //window.open('http://localhost:8000/Producto/listarPdf','_blank');
                window.open(this.ruta + '/Producto/listarPdf','_blank');
            },
            ReporteInventarioPdf(id){
                window.open(this.ruta + '/Entrada/listarPdf/'+ id +','+'_blank');
            },
            actualizarProducto(){
                if(this.validarActualizacion()){
                    return;
                }

                let me = this;
                axios.put(this.ruta +'/Producto/actualizar' ,{
                    'producto':this.producto,
                    
                    'id':this.producto_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarProducto(1,'','producto');
                }).catch(function(error){
                    console.log(error);
                })
            },
            mostrarDetalle(){
                this.listado=0;
            },
            ocultarDetalle(){
                this.listado=1;

                this.tituloModal='';
                this.producto='';
                
                this.fecha='';
                this.cantidad=0;
                this.costo_unitario=0.0;
                this.costo_total=0.0;
            },
            validarProducto(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto=[];
                if(!this.producto) this.errorMostrarMsjProducto.push("Ingrese producto");
                //if(!this.stock) this.errorMostrarMsjProducto.push("Ingrese la cantidad del producto");
                if(!this.cantidad||!this.costo_unitario||!this.costo_total) this.errorMostrarMsjProducto.push("Ingrese las existencias iniciales");
                if(this.errorMostrarMsjProducto.length) this.errorProducto=1;
                return this.errorProducto;
            },
            validarActualizacion(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto=[];
                if(!this.producto) this.errorMostrarMsjProducto.push("Ingrese producto");
                if(this.errorMostrarMsjProducto.length) this.errorProducto=1;
                return this.errorProducto;
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "producto":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tituloModal='Registar Nuevo producto'
                                this.producto='';
                                this.stock=0;
                                this.tipoAccion=1;
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tituloModal='Actualizar producto';
                                this.tipoAccion=2;
                                this.producto_id=data['id'];
                                this.producto=data['producto'];
                                this.stock=data['stock'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.producto='';
                
                this.fecha='';
                this.cantidad=0;
                this.costo_unitario=0.0;
                this.costo_total=0.0;
            }
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio);
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
        color: red;
        font-weight: bold;
    }
</style>
