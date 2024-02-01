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
use App\Http\Controllers\GomezApp\MenuController;
use App\Http\Controllers\GomezApp\UsuariosDepController;
use App\Http\Controllers\GomezApp\SParticularController;
use Illuminate\Support\Facades\Route;

#region CONTROLLERS




#endregion CONTROLLERS

Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);
Route::post('/users', [UserController::class, 'create']);
Route::post('/users/recovery', [UserController::class, 'recovery']);

Route::middleware('auth:sanctum')->group(function () {
   // Route::get('/getUser/{token}', [UserController::class,'getUser']); //cerrar sesión (eliminar los tokens creados)
   Route::post('/logout/{id}', [UserController::class, 'logout']); //cerrar sesión (eliminar los tokens creados)

   Route::controller(MenuController::class)->group(function () {
      Route::get('/menus', 'index');
      Route::get('/menus/selectIndex', 'selectIndex');
      Route::get('/menus/{id}', 'show');
      Route::post('/menus', 'create');
      Route::post('/menus/update/{id?}', 'update');
      Route::post('/menus/destroy/{id}', 'destroy');

      Route::get('/menus/MenusByRole/{pages_read}', 'MenusByRole');
      Route::post('/menus/getIdByUrl', 'getIdByUrl');
   });

   Route::controller(UserController::class)->group(function () {
      Route::get('/users', 'index');
      Route::get('/users/selectIndex', 'selectIndex');
      Route::get('/users/{id}', 'show');
      Route::post('/users/update/{id?}', 'update');
      Route::post('/users/destroy/{id}', 'destroy');
      Route::post('/users/updatepassword/{id}', 'updatePassword');

      Route::post('/users/destroyMultiple', 'destroyMultiple');
      Route::get('/users/{id}/disEnableUser/{active}', 'disEnableUser');
   });

   Route::controller(RoleController::class)->group(function () {
      Route::get('/roles', 'index');
      Route::get('/roles/selectIndex', 'selectIndex');
      Route::get('/roles/{id}', 'show');
      Route::post('/roles', 'create');
      Route::post('/roles/update/{id?}', 'update');
      Route::post('/roles/destroy/{id}', 'destroy');
   });

   Route::controller(DepartmentController::class)->group(function () {
      Route::get('/departments', 'index');
      Route::get('/departments/selectIndex', 'selectIndex');
      Route::get('/departments/{id}', 'show');
      Route::post('/departments', 'create');
      Route::post('/departments/update/{id?}', 'update');
      Route::post('/departments/destroy/{id}', 'destroy');
   });


   Route::controller(ReportController::class)->group(function () {
      Route::get('/reports', 'index');
      Route::post('/reports/id/{id}', 'destroy');
      Route::get('/reportsview', 'reportsview');
      Route::post('/reportsview', 'reportsviewById');
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
      Route::post('/asuntosdep', 'store');
      Route::post('/asuntosdep/deleted', 'destroy');
   });

   Route::controller(appController::class)->group(function () {
      Route::get('/asuntos', 'index');
      //   Route::post('/asuntos', 'store');
      Route::get('/asuntos/selectIndex', 'selectIndex');
      Route::get('/asuntos/{id}', 'show');
      Route::post('/asuntos/create', 'createOrUpdate');
      Route::post('/asuntos/update/{id}', 'createOrUpdate');
      Route::get('/asuntos/destroy/{id}', 'destroy');
   });

   Route::controller(UsuariosDepController::class)->group(function () {
      Route::get('/usuariosdep', 'index');
      Route::get('/usuariosdep/{id}', 'indexById');
   });
   Route::get('/sprequest', [SParticularController::class, 'index']);
   Route::get('/sprequest/{id}/{user_role_id}', [SParticularController::class, 'show']);
   Route::post('/sprequest', [SParticularController::class, 'store']);
   Route::post('/sprequest/destroy/{id}', [SParticularController::class, 'destroy']);
   Route::post('/sprequest/response/{id}', [SParticularController::class, 'response']);
   Route::post('/sprequest/update', [SParticularController::class, 'update']);
   Route::post('/requestviewxdeps', [SParticularController::class, 'requestviewByIdDep']);
});
