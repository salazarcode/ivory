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

/*
*
* Rutas de Users
*
*/
Route::post('register', 'Api\AuthController@register'); 
Route::post('login', 'Api\AuthController@login');
Route::get('users/{id?}', 'Api\AuthController@retrieve');

/*
*
* Rutas de Roles
*
*/
Route::post('roles', 'Api\RolesController@create');
Route::get('roles/{id?}', 'Api\RolesController@retrieve');
Route::post('roles/{id}', 'Api\RolesController@update');
Route::get('roles/{id}/drop', 'Api\RolesController@delete');
/*
*
* Rutas de Permisos
*
*/
Route::post('permisos', 'Api\PermisosController@create');
Route::get('permisos/{id?}', 'Api\PermisosController@retrieve');
Route::post('permisos/{id}', 'Api\PermisosController@update');
Route::get('permisos/{id}/drop', 'Api\PermisosController@delete');
Route::get('permisos/attach/user/{user_id}/permiso/{permiso_id}', 'Api\PermisosController@attach');
Route::get('permisos/detach/user/{user_id}/permiso/{permiso_id}', 'Api\PermisosController@detach');
/*
*
* Rutas de Marcas
*
*/
Route::post('marcas', 'Api\MarcasController@create');
Route::get('marcas/{id?}', 'Api\MarcasController@retrieve');
Route::post('marcas/{id}', 'Api\MarcasController@update');
Route::get('marcas/{id}/drop', 'Api\MarcasController@delete');
Route::get('marcas/usuario/{user_id}', 'Api\MarcasController@marcasDeUsuario');
Route::get('marcas/{marca_id}/sitios', 'Api\MarcasController@sitiosDeMarca');
/*
*
* Rutas de Sitios
*
*/
Route::post('sitios', 'Api\SitiosController@create');
Route::get('sitios/{id?}', 'Api\SitiosController@retrieve');
Route::post('sitios/{id}', 'Api\SitiosController@update');
Route::get('sitios/{id}/drop', 'Api\SitiosController@delete');
Route::get('sitios/attach/marca/{marca_id}/sitio/{sitio_id}', 'Api\SitiosController@attach');
Route::get('sitios/detach/marca/{marca_id}/sitio/{sitio_id}', 'Api\SitiosController@detach');
/*
*
* Rutas de Credenciales
*
*/
Route::post('credenciales', 'Api\CredencialesController@create');
Route::get('credenciales/{id?}', 'Api\CredencialesController@retrieve');
Route::post('credenciales/{id}', 'Api\CredencialesController@update');
Route::get('credenciales/{id}/drop', 'Api\CredencialesController@delete');
Route::get('credenciales/sitio/{sitio_id}/marca/{marca_id}', 'Api\CredencialesController@credencialesSitio');
/*
*
* Rutas de TCredenciales
*
*/
Route::post('tcredenciales', 'Api\TcredencialesController@create');
Route::get('tcredenciales/{id?}', 'Api\TcredencialesController@retrieve');
Route::post('tcredenciales/{id}', 'Api\TcredencialesController@update');
Route::get('tcredenciales/{id}/drop', 'Api\TcredencialesController@delete');