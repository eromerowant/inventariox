<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Entidades
Route::get('/entidades-registradas', 'EntidadeController@index')->name('entidadesRegistradas');
Route::post('/registrar-nueva-entidad', 'EntidadeController@storeNewEntidad')->name('storeNewEntidad');
Route::post('/registrar-nuevo-atributo', 'EntidadeController@storeNewAtributo')->name('storeNewAtributo');
Route::post('/borrar-entidad-existente', 'EntidadeController@borrarEntidadExistente')->name('borrarEntidadExistente');
Route::post('/actualizar-atributos-de-entidad', 'EntidadeController@updateAtributosDeEntidad')->name('updateAtributosDeEntidad');

Route::get('/compras-registradas-y-pendientes', 'CompraController@comprasRegistradasYPendientes')->name('comprasRegistradasYPendientes');
Route::get('/compras-registradas-y-recibidas', 'CompraController@comprasRegistradasYRecibidas')->name('comprasRegistradasYRecibidas');
Route::post('/registrar-nueva-compra', 'CompraController@registrarNuevaCompra')->name('registrarNuevaCompra');
Route::post('/eliminar-compra-registrada', 'CompraController@eliminarCompraRegistrada')->name('eliminarCompraRegistrada');
Route::post('/cambiar-status-de-compra-a-recibida', 'CompraController@CambiarStatusDeCompraARecibida')->name('CambiarStatusDeCompraARecibida');
Route::post('/cambiar-status-de-compra-a-pendiente', 'CompraController@CambiarStatusDeCompraAPendiente')->name('CambiarStatusDeCompraAPendiente');