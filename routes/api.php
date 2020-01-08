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
Route::post('update-art', 'ArticuloController@actualizar');
Route::post('delete-art', 'ArticuloController@artdelete');
// --------------------------------------------------------------------------------

//  apis de personas
Route::post('personas', 'PersonaController@personas');
//----------------------------------------------------------------------------------

// ingreso de venta y de detalle de venta
Route::post('create-venta', 'VentaController@getventa');
Route::post('create-detalle-venta', 'VentaController@getdetalleventa');

//------------------------------------------------------


// apis de ingresos de articulos
Route::post('create-ingreso', 'IngresoController@createingreso');
Route::post('create-detalle-ingreso', 'DetalleingresoController@registrodetalle');


//----------------------------------------------------------------------------------
Route::post('authenticate', 'LoginController@authenticate')->name('authenticate');
