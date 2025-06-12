<?php

use App\Http\Controllers\Api\DepotController;
use App\Http\Controllers\Api\SucursalleController;
use App\Http\Controllers\Api\VetementController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserController;
// use App\Http\Controllers\UserController;


use App\Http\Controllers\AuthController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EntrepriseController;
use App\Http\Controllers\Api\ClientController;
//use App\Http\Controllers\Api\DepotController;


use Illuminate\Http\Request;








//enregistrer un utilisateur
Route::post('/register', [UserController::class,'register']);
//connexion d'un utilisateur
Route::post('/login', [UserController::class,'login']);



Route::middleware('auth:sanctum')->group( function ()
{


// api utilisateur 
Route::put('/user/update/{id}', [UserController::class, 'update']);
Route::delete('/user/delete/{id}', [UserController::class,'delete']);
Route::get('/user', function(Request $request){
    return $request->user();
});



//api entreprise
Route::post('/create/entreprise', [EntrepriseController::class,'register']);


// api sucursalle
Route::post('/create/sucursalle', [SucursalleController::class, 'register']);


// api client 
//Route::get('/get/all/client', function(Request $request){
  //  return $request->client();
//});
Route::get('/get/all/client', [ClientController::class,'index']);
Route::post('/create/client', [ClientController::class, 'register']);
Route::put('/update/client/{client_id}', [ClientController::class,'update']);
Route::delete('/delete/client/{client_id}', [ClientController::class,'delete']);

// api Depot
Route::get('/get/depot', [DepotController::class,'index']);
Route::post('/create/depot', [DepotController::class,'register']);
Route::delete('/delete/depot/{depot_id}', [DepotController::class,'delete']);

// api vetement
Route::get('/get/vetement/{depot_id}', [VetementController::class,'index']);
Route::post('/create/vetement', [VetementController::class,'register']);
Route::put('/update/vetement/{vetement_id}', [VetementController::class,'update']);
});