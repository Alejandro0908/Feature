<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProyectoController;

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



Route::post('/proyecto' , [ProyectoController::class, 'store']);

Route::get('/proyecto' , [ProyectoController::class, 'index']);

Route::put('/proyecto/{proyecto}' , [ProyectoController::class, 'update']);

Route::put('/proyecto/{proyecto}', [ProyectoController::class, 'update'])->name('proyecto.update');;

Route::get('/proyecto/{proyecto}' , [ProyectoController::class, 'show']);

Route::delete('/proyecto/{proyecto}', [ProyectoController::class, 'destroy']);






