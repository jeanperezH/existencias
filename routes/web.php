<?php

Route::get('/', function () {
    return view('contenido.contenido');
});
//Producto
Route::get('/Producto','ProductoController@index');
Route::post('/Producto/registrar','ProductoController@store');
Route::put('/Producto/actualizar','ProductoController@update');
Route::get('/Producto/selectProducto','ProductoController@selectProducto');
Route::get('/Producto/listarPdf','ProductoController@listarPdf')->name('productos_pdf');
Route::get('/In_Out/metodoPMP/{id}','In_OutController@metodoPMP')->name('pmp_pdf');
//Compras
Route::get('/Compra','CompraController@index');
Route::post('/Compra/registrar','CompraController@store');
Route::get('/Compra/listarPdf/{id}','CompraController@listarPdf')->name('entradas_pdf');
//Ventas
Route::get('/Venta','VentaController@index');
Route::post('/Venta/registrar','VentaController@store');
//Entrada
Route::get('/Entrada','EntradaController@index');
Route::post('/Entrada/registrar','EntradaController@store');
Route::get('/Entrada/listarPdf/{id}','EntradaController@listarPdf')->name('entradas_pdf');
//Salida
Route::get('/Salida','SalidaController@index');
Route::post('/Salida/registrar','SalidaController@store');

//Pedido
Route::get('/Pedido','PedidoController@index');
Route::post('/Pedido/registrar','PedidoController@store');


