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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'admin','namespace' => 'Auth'],function(){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::get('/', 'HomeController@index')->name('index');

Route::get('/home', 'HomeController@index')->name('index');

Route::prefix('admin')->namespace('Admin')->group(function () {
    /*  Operadores */
    // nota mental :: as rotas extras devem ser declaradas antes de se declarar as rotas resources
    Route::get('/users/password', 'ChangePasswordController@showPasswordUpdateForm')->name('users.password');
    Route::put('/users/password/update', 'ChangePasswordController@passwordUpdate')->name('users.passwordupdate');
    // relatorios
    Route::get('/users/export/csv', 'UserController@exportcsv')->name('users.export.csv');
    Route::get('/users/export/xls', 'UserController@exportxls')->name('users.export.xls');
    Route::get('/users/export/pdf', 'UserController@exportpdf')->name('users.export.pdf');
    // crud
    Route::resource('/users', 'UserController');

    /* Permissões */
    # relatorios
    Route::get('/permissions/export/csv', 'PermissionController@exportcsv')->name('permissions.export.csv');
    Route::get('/permissions/export/xls', 'PermissionController@exportxls')->name('permissions.export.xls');
    Route::get('/permissions/export/pdf', 'PermissionController@exportpdf')->name('permissions.export.pdf');
    #crud
    Route::resource('/permissions', 'PermissionController');

    /* Perfis */
    # relatorios
    Route::get('/roles/export/csv', 'RoleController@exportcsv')->name('roles.export.csv');
    Route::get('/roles/export/xls', 'RoleController@exportxls')->name('roles.export.xls');
    Route::get('/roles/export/pdf', 'RoleController@exportpdf')->name('roles.export.pdf');
    # crud
    Route::resource('/roles', 'RoleController');
});

Route::prefix('sistema')->group(function () {
    /* Raças */
    # relatorios
    Route::get('/racas/export/csv', 'RacaController@exportcsv')->name('racas.export.csv');
    Route::get('/racas/export/xls', 'RacaController@exportxls')->name('racas.export.xls');
    Route::get('/racas/export/pdf', 'RacaController@exportpdf')->name('racas.export.pdf');
    # crud
    Route::resource('/racas', 'RacaController');

    /* Situações do pedido */
    # relatorios
    Route::get('/situacaos/export/csv', 'SituacaoController@exportcsv')->name('situacaos.export.csv');
    Route::get('/situacaos/export/xls', 'SituacaoController@exportxls')->name('situacaos.export.xls');
    Route::get('/situacaos/export/pdf', 'SituacaoController@exportpdf')->name('situacaos.export.pdf');
    # crud
    Route::resource('/situacaos', 'SituacaoController');

    /* Pedidos */
    # relatorios
    Route::get('/pedidos/clear/session', 'PedidoController@clearsession')->name('pedidos.clear.session');
    Route::get('/pedidos/export/csv', 'PedidoController@exportcsv')->name('pedidos.export.csv');
    Route::get('/pedidos/export/xls', 'PedidoController@exportxls')->name('pedidos.export.xls');
    Route::get('/pedidos/export/pdf', 'PedidoController@exportpdf')->name('pedidos.export.pdf');
    # crud
    Route::resource('/pedidos', 'PedidoController');
});    

