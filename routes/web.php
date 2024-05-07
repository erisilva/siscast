<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Auth;

use App\Models\Pedido;

use Carbon\Carbon;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RacaController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\ParamController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# about page
Route::get('/about', function () {
    return view('about.about');
})->name('about')->middleware('auth');

Route::get('/', function () {
    #if the user is logged return index view, if not logged return login view
    if (Auth::check()) {
        return view('index');
    } else {
        return view('auth.login');
    }
});

# add 'register' => false to Auth::routes() to disable registration
Auth::routes(['verify' => false, 'register' => false]);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth');
Route::post('/profile/update/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme.update')->middleware('auth');

# Permission::class

Route::get('/permissions/export/csv', [PermissionController::class, 'exportcsv'])->name('permissions.export.csv')->middleware('auth');

Route::get('/permissions/export/xls', [PermissionController::class, 'exportxls'])->name('permissions.export.xls')->middleware('auth'); // Export XLS

Route::get('/permissions/export/pdf', [PermissionController::class, 'exportpdf'])->name('permissions.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/permissions', PermissionController::class)->middleware('auth'); // Resource Route, crud

# Role::class

Route::get('/roles/export/csv', [RoleController::class, 'exportcsv'])->name('roles.export.csv')->middleware('auth'); // Export CSV

Route::get('/roles/export/xls', [RoleController::class, 'exportxls'])->name('roles.export.xls')->middleware('auth'); // Export XLS

Route::get('/roles/export/pdf', [RoleController::class, 'exportpdf'])->name('roles.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/roles', RoleController::class)->middleware('auth'); // Resource Route, crud

# User::class

Route::get('/users/export/csv', [UserController::class, 'exportcsv'])->name('users.export.csv')->middleware('auth'); // Export CSV

Route::get('/users/export/xls', [UserController::class, 'exportxls'])->name('users.export.xls')->middleware('auth'); // Export XLS

Route::get('/users/export/pdf', [UserController::class, 'exportpdf'])->name('users.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/users', UserController::class)->middleware('auth'); // Resource Route, crud

# Log::class

Route::resource('/logs', LogController::class)->middleware('auth')->only('show', 'index'); // Resource Route, crud

# Raca::class

Route::get('/racas/export/csv', [RacaController::class, 'exportcsv'])->name('racas.export.csv')->middleware('auth'); // Export CSV

Route::get('/racas/export/xls', [RacaController::class, 'exportxls'])->name('racas.export.xls')->middleware('auth'); // Export XLS

Route::get('/racas/export/pdf', [RacaController::class, 'exportpdf'])->name('racas.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/racas', RacaController::class)->middleware('auth'); // Resource Route, crud

# Situacao::class

Route::get('/situacaos/export/csv', [SituacaoController::class, 'exportcsv'])->name('situacaos.export.csv')->middleware('auth'); // Export CSV

Route::get('/situacaos/export/xls', [SituacaoController::class, 'exportxls'])->name('situacaos.export.xls')->middleware('auth'); // Export XLS

Route::get('/situacaos/export/pdf', [SituacaoController::class, 'exportpdf'])->name('situacaos.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/situacaos', SituacaoController::class)->middleware('auth'); // Resource Route, crud

# Pedido::class

Route::get('/pedidos/export/csv', [PedidoController::class, 'exportcsv'])->name('pedidos.export.csv')->middleware('auth'); // Export CSV

Route::get('/pedidos/export/xls', [PedidoController::class, 'exportxls'])->name('pedidos.export.xls')->middleware('auth'); // Export XLS

Route::get('/pedidos/export/pdf', [PedidoController::class, 'exportpdf'])->name('pedidos.export.pdf')->middleware('auth'); // Export PDF

Route::resource('/pedidos', PedidoController::class)->middleware('auth'); // Resource Route, crud


# relatorios por status (Mesmo que situação) e período 
Route::get('/relatorio/porsituacao/xls', [RelatorioController::class, 'porSituacaoExportXLSX'])->name('relatorio.porsituacao.xls');
Route::get('/relatorio/porsituacao/csv', [RelatorioController::class, 'porSituacaoExportCSV'])->name('relatorio.porsituacao.csv');
Route::get('/relatorio/porsituacao', [RelatorioController::class, 'porSituacao'])->name('relatorio.porsituacao');



Route::get('/relatorio', [RelatorioController::Class, 'index'])->name('relatorio.index');

# Parametros
Route::resource('/params', ParamController::class)->middleware('auth'); // Resource Route, crud


