@extends('principal')
@section('contenido')
  <template v-if="menu==0">
    <Producto :ruta="ruta"></Producto>
  </template>
  <template v-if="menu==1">
    <Compra :ruta="ruta"></Compra>
  </template>
  <template v-if="menu==2">
    <Venta :ruta="ruta"></Venta>
  </template>
  <template v-if="menu==3">
    <Pedido :ruta="ruta"></Pedido>
  </template>
  
@endsection