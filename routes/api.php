<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//  gestion de articulos
Route::post('articulos', 'ArticuloController@articulos');
Route::post('set-articulos', 'ArticuloController@setarticulos');
Route::post('set-articulos-sin', 'ArticuloController@setarticulosSin');
Route::post('update-art', 'ArticuloController@actualizar');
Route::post('delete-art', 'ArticuloController@artdelete');
Route::post('categoria-all', 'ArticuloController@setcategorias');
Route::post('save-articulo', 'ArticuloController@storearticulo');


// --------------------------------------------------------------------------------

//  apis de personas
Route::post('personas', 'PersonaController@personas');
//----------------------------------------------------------------------------------

// ingreso de venta y de detalle de venta
Route::post('create-venta', 'VentaController@getventa');
Route::post('create-detalle-venta', 'VentaController@getdetalleventa');
Route::post('all-ventas', 'VentaController@sendventas');

// ----base del dia ------------------
Route::post('base', 'VentaController@baseDay');
Route::post('savebase', 'VentaController@saveBase');




//------------------------------------------------------


// apis de ingresos de articulos
Route::post('create-ingreso', 'IngresoController@createingreso');
Route::post('create-detalle-ingreso', 'DetalleingresoController@registrodetalle');
Route::post('all-ingresos', 'IngresoController@setingresos');

// busqueda avanzada
Route::post('busqueda-ingreso', 'IngresoController@busquedaingreso');
Route::post('busqueda-ingreso-fecha', 'IngresoController@setingresofecha');
Route::post('busqueda-ingreso-mes', 'IngresoController@setmesingreso');
// ------------------------------------

//----------------------------------------------------------------------------------
Route::post('authenticate', 'LoginController@authenticate')->name('authenticate');


// apis para la seccion de panaderia
Route::post('set-pan', 'ArticuloController@setpanaderia')->name('set-pan');
Route::post('save-pan', 'ArticuloController@savepan')->name('save-pan');
Route::post('update-pan', 'ArticuloController@updatepan')->name('update-pan');
Route::post('baja-pan', 'ArticuloController@bajapan')->name('baja-pan');
Route::post('list-baja-pan', 'ArticuloController@setbajaart')->name('list-baja-pan');
Route::post('list-ingreso-pan', 'ArticuloController@setingresopan')->name('list-ingreso-pan');

// -------------------------------------------------------------------------------------