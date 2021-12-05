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

Route::get('/configuracion', 'SidebarController@configuracion')->name('configuracion');
//compras
Route::get('/compras/index', 'SidebarController@comprasIndex')->name('compras.index');
Route::get('/compras/create', 'SidebarController@comprasCreate')->name('compras.create');
Route::get('/compras/show/{compra_id}', 'SidebarController@comprasShow')->name('compras.show');
// ventas
Route::get('/ventas/index', 'SidebarController@ventasIndex')->name('ventas.index');
Route::get('/ventas/create', 'SidebarController@ventasCreate')->name('ventas.create');
Route::get('/ventas/show/{venta_id}', 'SidebarController@ventasShow')->name('ventas.show');

// inventario
Route::get('/inventario/index', 'SidebarController@inventarioIndex')->name('inventario.index');


Route::get('/home', 'HomeController@index')->name('home');

//Entidades
Route::get('/entidades-registradas', 'EntidadeController@index')->name('entidadesRegistradas');
Route::post('/get_entidad', 'EntidadeController@get_entidad')->name('get_entidad');
Route::post('/registrar-nueva-entidad', 'EntidadeController@storeNewEntidad')->name('storeNewEntidad');
Route::delete('/borrar-entidad-existente', 'EntidadeController@borrarEntidadExistente')->name('borrarEntidadExistente');
Route::post('/actualizar-atributos-de-entidad', 'EntidadeController@updateAtributosDeEntidad')->name('updateAtributosDeEntidad');
Route::post('/addNewAttributeInDataBase', 'PossibleAttributeController@addNewAttributeInDataBase')->name('addNewAttributeInDataBase');
Route::delete('/removeAttributeFromEntity', 'PossibleAttributeController@removeAttributeFromEntity')->name('removeAttributeFromEntity');
Route::post('/updateAttributeInEntity', 'PossibleAttributeController@updateAttributeInEntity')->name('updateAttributeInEntity');
Route::post('/addNewValueToPossibleAttribute', 'PossibleAttributeController@addNewValueToPossibleAttribute')->name('addNewValueToPossibleAttribute');
Route::delete('/removeValueFromAttributeInDatabase', 'PossibleAttributeController@removeValueFromAttributeInDatabase')->name('removeValueFromAttributeInDatabase');

Route::get('/compras-registradas-y-pendientes', 'CompraController@comprasRegistradasYPendientes')->name('comprasRegistradasYPendientes');
Route::get('/compras-registradas-y-recibidas', 'CompraController@comprasRegistradasYRecibidas')->name('comprasRegistradasYRecibidas');
Route::post('/registrar-nueva-compra', 'CompraController@registrarNuevaCompra')->name('registrarNuevaCompra');
Route::post('/eliminar-compra-registrada', 'CompraController@eliminarCompraRegistrada')->name('eliminarCompraRegistrada');
Route::post('/cambiar-status-de-compra-a-recibida', 'CompraController@CambiarStatusDeCompraARecibida')->name('CambiarStatusDeCompraARecibida');
Route::post('/cambiar-status-de-compra-a-pendiente', 'CompraController@CambiarStatusDeCompraAPendiente')->name('CambiarStatusDeCompraAPendiente');

Route::post('recibir_compra', 'CompraController@recibir_compra')->name('recibir_compra');
Route::post('compra_en_camino', 'CompraController@compra_en_camino')->name('compra_en_camino');



Route::get('entities/index', 'EntityController@index')->name('entities.index');




Route::get('/mostrar-ejemplares', 'EjemplareController@index')->name('VerEjemplares');