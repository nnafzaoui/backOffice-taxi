<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PermissionController;

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

// Route::get('/', [dashboardController::class, 'index']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'permission:dashboard'])->group(function () {
    Route::get('/', [dashboardController::class, 'index']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function() {
        return view('board');
    });
});

// Route::get('/notadminplace',function() {
//     return view('errors.404');
// });

Route::group(['middleware' => ['permission:dashboard']], function () {

    Route::get('/drivers', [DriversController::class, 'index']);

    Route::get('/customers', function (){
        return view('customers');
    });

    Route::get('/routes', function (){
        return view('routes');
    });

    Route::get('/profiles', function (){
        return view('profiles');
    });

    Route::resources([
        'drivers' => DriversController::class,
        'roles' => RoleController::class,
        'permission' => PermissionController::class
    ]);

    Route::post('/revoke', [RoleController::class, 'revokePermissions'])->name('revoke');

    Route::get('/rolesusers', [RoleController::class, 'index']);

    Route::get('/roles', [RoleController::class, 'rolesIndex']);

    // Route::get('/permission', [RoleController::class, 'permissionIndex']);
});

require __DIR__.'/auth.php';