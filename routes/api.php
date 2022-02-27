<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\EmployeeManagement\Employee;
use App\Http\Controllers\Api\UserManagement\User;
use App\Http\Controllers\Api\UserManagement\Role;
use App\Http\Controllers\Api\ModuleManagement\Module;
use App\Http\Controllers\Api\ModuleManagement\SubModule;
use App\Http\Controllers\Api\Reference\Group;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {

    Route::post('/sign-in', [Auth::class, 'signIn']);
    Route::post('/verify-token', [Auth::class, 'verifyToken']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('auth')->group(function () {

        Route::post('/sign-out', [Auth::class, 'signOut']);
        Route::post('/sign-out-all', [Auth::class, 'signOutAll']);
    });

    Route::prefix('user-management')->group(function () {

        Route::prefix('user')->group(function () {

            Route::get('/index', [User::class, 'index']);
            Route::get('/unique', [User::class, 'unique']);
            Route::get('/get-access-rights', [User::class, 'getAccessRights']);

            Route::post('/store', [User::class, 'store']);

            Route::put('/save', [User::class, 'save']);
            Route::put('/reset-password', [User::class, 'resetPassword']);

            Route::delete('/destroy', [User::class, 'destroy']);
        });

        Route::prefix('role')->group(function () {

            Route::get('/index', [Role::class, 'index']);
            Route::get('/unique', [Role::class, 'unique']);
            Route::get('/get-role', [Role::class, 'getRole']);
            Route::get('/get-permission', [Role::class, 'getPermission']);

            Route::post('/store', [Role::class, 'store']);

            Route::put('/save', [Role::class, 'save']);

            Route::delete('/destroy', [Role::class, 'destroy']);
        });
    });

    Route::prefix('employee-management')->group(function () {

        Route::prefix('employee')->group(function () {

            Route::get('/index', [Employee::class, 'index']);
            Route::get('/unique', [Employee::class, 'unique']);

            Route::post('/store', [Employee::class, 'store']);

            Route::put('/save', [Employee::class, 'save']);

            Route::delete('/destroy', [Employee::class, 'destroy']);
        });
    });

    Route::prefix('module-management')->group(function () {

        Route::prefix('module')->group(function () {

            Route::get('/index', [Module::class, 'index']);
            Route::get('/unique', [Module::class, 'unique']);

            Route::post('/store', [Module::class, 'store']);

            Route::put('/save', [Module::class, 'save']);

            Route::delete('/destroy', [Module::class, 'destroy']);
        });

        Route::prefix('sub-module')->group(function () {

            Route::get('/index', [SubModule::class, 'index']);
            Route::get('/unique', [SubModule::class, 'unique']);

            Route::post('/store', [SubModule::class, 'store']);

            Route::put('/save', [SubModule::class, 'save']);

            Route::delete('/destroy', [SubModule::class, 'destroy']);
        });
    });

    Route::prefix('reference')->group(function () {

        Route::prefix('group')->group(function () {

            Route::get('/index', [Group::class, 'index']);
            Route::get('/unique', [Group::class, 'unique']);

            Route::post('/store', [Group::class, 'store']);

            Route::put('/save', [Group::class, 'save']);

            Route::delete('/destroy', [Group::class, 'destroy']);
        });
    });

});

Route::get('version', function () {
    return phpinfo();
});
