<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/setPassword/{id}', [UserController::class, 'getSetPassword'])->name('set.password');
Route::post('/setPassword', [UserController::class, 'postSetPassword'])->name('set.password.post');

Route::middleware("auth")->group(function () {
    Route::get('/clients/export', [ClientController::class, 'exportExcel'])->name('clients.export');
    Route::post('/clients/import', [ClientController::class, 'importExcel'])->name('clients.import');
    Route::get('/clients/filter/{id}', [ClientController::class, 'index']);
    Route::resources([
        'cities'  => CityController::class,
        'clients' => ClientController::class,
        'users'   => UserController::class,
    ]);

});

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
