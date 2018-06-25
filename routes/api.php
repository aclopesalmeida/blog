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


Route::get('/posts', [
    'uses' => 'PostsController@posts'
]);
Route::get('/post', [
    'uses' => 'PostsController@ver'
]);
Route::get('/categorias', [
    'uses' => 'PostsController@postsCategoria'
]);
Route::post('/contactos', [
    'uses' => 'ContactosController@enviarEmail'
]);


Route::post('/admin/login', [
    'uses' => 'Admin\UtilizadoresController@login'
]);


Route::group([
    'prefix' => '/admin',
    'middleware' => 'jwt.auth'
], function() {

    Route::get('/xx', [
        'uses' => 'Admin\UtilizadoresController@teste'
    ]);
    Route::get('/logout', [
        'uses' => 'Admin\UtilizadoresController@logout'
    ]);
    
    Route::get('/posts', [
        'uses' => 'Admin\PostsController@posts'
    ]);
        
    Route::post('/posts/criar', [
        'uses' => 'Admin\PostsController@criar'
    ]);
    Route::post('/posts/editar', [
        'uses' => 'Admin\PostsController@editar'
    ]);
    Route::post('/posts/apagar', [
        'uses' => 'Admin\PostsController@apagar'
    ]);

    Route::get('/comentarios', [
        'uses' => 'Admin\ComentariosController@comentarios'
    ]);

    Route::post('/comentarios/apagar', [
        'uses' => 'Admin\ComentariosController@apagar'
    ]);

    Route::get('/categorias', [
        'uses' => 'Admin\CategoriasController@categorias'
    ]);
    Route::post('/categorias/criar', [
        'uses' => 'Admin\CategoriasController@criar'
    ]);
    Route::post('/categorias/editar', [
        'uses' => 'Admin\CategoriasController@editar'
    ]);
    Route::post('/categorias/apagar', [
        'uses' => 'Admin\CategoriasController@apagar'
    ]);
    Route::get('/utilizadores/check', [
        'uses' => 'Admin\UtilizadoresController@check'
    ]);
    Route::get('/utilizadores/utilizadorautenticado', [
        'uses' => 'Admin\UtilizadoresController@getUtilizadorAutenticado'
    ]);
    Route::get('/utilizadores', [
        'uses' => 'Admin\UtilizadoresController@utilizadores'
    ]);
    Route::get('/utilizador', [
        'uses' => 'Admin\UtilizadoresController@ver'
    ]);
    Route::post('/utilizadores/criar', [
        'uses' => 'Admin\UtilizadoresController@criar'
    ]);
    Route::post('/utilizadores/editar', [
        'uses' => 'Admin\UtilizadoresController@editar'
    ]);
    Route::post('/utilizadores/apagar', [
        'uses' => 'Admin\UtilizadoresController@apagar'
    ]);

    Route::get('/cargos', [
        'uses' => 'Admin\CargosController@cargos'
    ]);
    Route::get('/cargo', [
        'uses' => 'Admin\CargosController@ver'
    ]);
    Route::post('/cargos/criar', [
        'uses' => 'Admin\CargosController@criar'
    ]);
    Route::post('/cargos/editar', [
        'uses' => 'Admin\CargosController@editar'
    ]);
    Route::post('/cargos/apagar', [
        'uses' => 'Admin\CargosController@apagar'
    ]);
});


