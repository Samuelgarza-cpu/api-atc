<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GomezApp\RoleController;
use App\Http\Controllers\GomezApp\DepartmentController;
use App\Http\Controllers\GomezApp\OrigenController;
use App\Http\Controllers\GomezApp\ReportController;
use App\Http\Controllers\GomezApp\TipoReporteController;
use App\Http\Controllers\GomezApp\ServiceController;
use App\Http\Controllers\GomezApp\AsuntosDepController;
use App\Http\Controllers\GomezApp\appController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region CONTROLLERS




#endregion CONTROLLERS

Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);
Route::post('/users', [UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
   // Route::get('/getUser/{token}', [UserController::class,'getUser']); //cerrar sesión (eliminar los tokens creados)
   Route::post('/logout/{id}', [UserController::class, 'logout']); //cerrar sesión (eliminar los tokens creados)

   Route::controller(UserController::class)->group(function () {
      Route::get('/users', 'index');
      Route::get('/users/selectIndex', 'selectIndex');
      Route::get('/users/{id}', 'show');
      Route::put('/users/{id?}', 'update');
      Route::delete('/users/{id}', 'destroy');
   });

   Route::controller(RoleController::class)->group(function () {
      Route::get('/roles', 'index');
      Route::get('/roles/selectIndex', 'selectIndex');
      Route::get('/roles/{id}', 'show');
      Route::post('/roles', 'create');
      Route::put('/roles/{id?}', 'update');
      Route::delete('/roles/{id}', 'destroy');
   });

   Route::controller(DepartmentController::class)->group(function () {
      Route::get('/departments', 'index');
      Route::get('/departments/selectIndex', 'selectIndex');
      Route::get('/departments/{id}', 'show');
      Route::post('/departments', 'create');
      Route::put('/departments/{id?}', 'update');
      Route::delete('/departments/{id}', 'destroy');
   });


   Route::controller(ReportController::class)->group(function () {
      Route::get('/reports', 'index');
      Route::post('/reports/id/{id}', 'destroy');
      Route::get('/reportsview', 'reportsview');
      Route::get('/icards', 'getCards');
      Route::post('/reports', 'saveReport');
      Route::post('/reports/response', 'saveResponse');
      Route::post('/reports/response/{id}', 'deleteResponse');
      Route::get('/reports/user/{id_user}', 'reportsByUser');
      Route::get('/reports/{id}', 'reportsById');
   });

   Route::controller(TipoReporteController::class)->group(function () {
      Route::get('/reportTypes', 'index');
      Route::get('/reportTypes/selectIndex', 'selectIndex');
      Route::get('/reportTypes/{id}', 'show');
      Route::post('/reportTypes', 'create');
      Route::put('/reportTypes/{id?}', 'update');
      Route::delete('/reportTypes/{id}', 'destroy');
   });


   Route::controller(ServiceController::class)->group(function () {
      Route::get('/services', 'index');
   });

   Route::controller(OrigenController::class)->group(function () {
      Route::get('/origen', 'index');
   });

   Route::controller(AsuntosDepController::class)->group(function () {
      Route::get('/asuntosdep', 'index');
      Route::get('/asuntosdep/{id}', 'show');
   });

   Route::controller(appController::class)->group(function () {
      Route::get('/asuntos', 'index');
      Route::post('/asuntos', 'store');
   });
});
