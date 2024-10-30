<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\AuthController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function(){
    Route::put('/marcas/{marcas}', [MarcasController::class, 'update']);
    Route::delete('/marcas/{marcas}', [MarcasController::class, 'destroy']);
    Route::resource('marcas' , MarcasController::class);
    Route::resource('equipos' , EquiposController::class);
    Route::put('/equipos/{equipos}', [EquiposController::class, 'update']);
    Route::delete('/equipos/{equipos}', [EquiposController::class, 'destroy']);
    Route::get('equiposall',[EquiposController::class, 'all']);
    Route::get('equiposbymarcas',[EquiposController::class, 'EquiposByMarcas']);
    Route::get('auth/logout', [AuthController::class, 'logout']);
        
});
