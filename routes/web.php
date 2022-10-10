<?php

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

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommuneDistanceController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\ConfirmedLevelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\LeaveDocController;
use App\Http\Controllers\ServiceController;



Route::get('/users_list', [UserController::class, 'show'])->name('users-list')->middleware(['auth', 'role:admin|superadmin']);


Auth::routes();
Route::get('/', [UserController::class, 'index'])->name('home')->middleware('auth');
Route::get('/user_profile', [UserController::class, 'user_profile'])->name('user-profile')->middleware('auth');
Route::post('/change_password', [UserController::class, 'change-password'])->name('change-password')->middleware('auth');
Route::put('/update_information', [UserController::class, 'update_information'])->name('update-profile')->middleware('auth');
Route::get('/commune_distances_list', [CommuneDistanceController::class, 'show'])->name('commune-distances-list')->middleware(['auth', 'role:admin|superadmin']);
Route::get('/get_users', [UserController::class, 'get_users'])->name('get-users')->middleware(['auth', 'role:admin|superadmin']);
Route::get('/create_user', [UserController::class, 'create'])->name('create-user')->middleware(['auth', 'role:admin|superadmin']);
Route::post('/add_user', [UserController::class, 'store'])->name('user-add')->middleware(['auth', 'role:admin|superadmin']);
Route::get('/edit_user/{id}', [UserController::class, 'edit'])->name('edit-user')->middleware(['auth', 'role:admin|superadmin']);
Route::put('/update_user/{id}', [UserController::class, 'update'])->name('update-user')->middleware(['auth', 'role:admin|superadmin']);
Route::delete('/user_delete/{id}', [UserController::class, 'destroy'])->name('user-delete')->middleware(['auth', 'role:admin|superadmin']);

Route::put('/updateDecompte/{id}', [MissionController::class, 'update_decompte'])->name('decompte-update')->middleware(['auth']);

Route::get('/getUsers', [UserController::class, 'getUsers'])->name('getUsers')->middleware(['auth', 'role:admin|superadmin']);

Route::get('/getCommuneDistances', [CommuneDistanceController::class, 'getCommuneDistances'])->name('getCommuneDistances')->middleware(['auth', 'role:admin|superadmin']);

Route::get('/missions_list', [MissionController::class, 'index'])->name('missions-list')->middleware(['auth', 'role_or_permission:user']);

Route::get('/functions_list', [FonctionController::class, 'index'])->name('functions-list')->middleware(['auth', 'role_or_permission:user']);

Route::get('/leavedocs_list', [LeaveDocController::class, 'index'])->name('leavedocs-list')->middleware(['auth', 'role_or_permission:user']);



Route::get('/roles_list', [RoleController::class, 'index'])->name('roles-list')->middleware(['auth', 'role:superadmin']);
Route::get('/services_list', [ServiceController::class, 'index'])->name('services-list')->middleware(['auth', 'role:superadmin|admin']);

Route::get('/confirmedlevels_list', [ConfirmedLevelController::class, 'index'])->name('confirmedlevels-list')->middleware(['auth', 'role_or_permission:user']);

Route::get('/getRoles', [RoleController::class, 'getRoles'])->name('getRoles')->middleware(['auth', 'role:superadmin']);
Route::get('/getServices', [ServiceController::class, 'getServices'])->name('geServices')->middleware(['auth', 'role:superadmin|admin']);
Route::post('/role_assign_permissions/{id}', [RoleController::class, 'assignPermissions'])->name('role-assign-permissions')->middleware(['auth', 'role:superadmin']);

Route::post('/role_revoke_permission/{id}', [RoleController::class, 'revokePermission'])->name('role-revoke-permissions')->middleware(['auth', 'role:superadmin']);
Route::post('/role_add', [RoleController::class, 'store'])->name('role-add')->middleware(['auth', 'role:superadmin']);

Route::put('/role_edit/{id}', [RoleController::class, 'update'])->name('role-update')->middleware(['auth', 'role:superadmin']);

Route::delete('/role_delete/{id}', [RoleController::class, 'destroy'])->name('role-delete')->middleware(['auth', 'role:superadmin']);

Route::get('/permissions_list', [PermissionController::class, 'index'])->name('permissions-list')->middleware(['auth', 'role:superadmin']);
Route::post('/permission_add', [PermissionController::class, 'store'])->name('permission-add')->middleware(['auth', 'role:superadmin']);

Route::put('/permission_edit/{id}', [PermissionController::class, 'update'])->name('permission-update')->middleware(['auth', 'role:superadmin']);

Route::delete('/permission_delete/{id}', [PermissionController::class, 'destroy'])->name('permission-delete')->middleware(['auth', 'role:superadmin']);

Route::delete('/missions', [MissionController::class, 'destroyAll'])->name('missions-delete')->middleware(['auth', 'role_or_permission:user']);
Route::get('/getPermissions', [PermissionController::class, 'getPermissions'])->name('getPermissions')->middleware(['auth', 'role:superadmin']);



Route::resource('photos', PhotoController::class);



Route::resource('permissions', PermissionController::class);
Route::resource('services', ServiceController::class)->middleware(['auth', 'role_or_permission:admin|superadmin']);
Route::resource('agents', AgentController::class)->middleware(['auth', 'role_or_permission:user']);
Route::resource('missions', MissionController::class)->middleware(['auth', 'role_or_permission:user']);

Route::resource('fonctions', FonctionController::class)->middleware(['auth', 'role_or_permission:user']);
Route::resource('services', ServiceController::class)->middleware(['auth', 'role_or_permission:admin|superadmin']);

Route::resource('leavedocs', LeaveDocController::class)->middleware(['auth', 'role_or_permission:user']);

Route::resource('confirmedLevels', ConfirmedLevelController::class)->middleware(['auth', 'role_or_permission:user']);

Route::post('/getDistances', [MissionController::class, 'getDistances'])->middleware(['auth', 'role_or_permission:user']);
Route::resource('commune_distances', CommuneDistanceController::class)->middleware(['auth', 'role_or_permission:admin||superadmin']);
Route::get('/getAgents', [AgentController::class, 'getAgents'])->middleware(['auth', 'role_or_permission:user']);

Route::get('/getMissions', [MissionController::class, 'getMissions'])->middleware(['auth', 'role_or_permission:user']);
Route::get('/getFonctions', [FonctionController::class, 'getFonctions'])->middleware(['auth', 'role_or_permission:user']);
Route::get('/getLeaveDocs', [LeaveDocController::class, 'getLeaveDocs'])->middleware(['auth', 'role_or_permission:user']);
Route::get('/getConfirmedLevels', [ConfirmedLevelController::class, 'getConfirmedLevels'])->middleware(['auth', 'role_or_permission:user']);








Route::get('/lol', function () {
    $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
    $beautymail->send('emails.welcome', [], function ($message) {
        $message
            ->from('esselamia@cnas.com')
            ->to('esselamia@cnas.com', 'John Smith')
            ->subject('Welcome!');
    });
});




// Route::get('/', 'UserController@index')->name('home')->middleware('auth');
// Route::post('/change_password', 'UserController@change_password')->name('change-password')->middleware('auth');
// Route::get('/user_profile', 'UserController@user_profile')->name('user-profile')->middleware('auth');
// Route::put('/update_information', 'UserController@update_information')->name('update-profile')->middleware('auth');
// Route::get('/users_list', 'UserController@show')->name('users-list')->middleware(['auth','role:admin|superadmin']);
// Route::get('/commune_distances_list', 'CommuneDistanceController@index')->name('commune-distances-list')->middleware(['auth','role:admin|superadmin']);
// Route::get('/get_users', 'UserController@get_users')->name('get-users')->middleware(['auth','role:admin|superadmin']);
// Route::get('/create_user', 'UserController@create')->name('create-user')->middleware(['auth','role:admin|superadmin']);
// Route::post('/add_user', 'UserController@store')->name('user-add')->middleware(['auth','role:admin|superadmin']);
// Route::get('/edit_user/{id}', 'UserController@edit')->name('edit-user')->middleware(['auth','role:admin|superadmin']);
// Route::put('/update_user/{id}', 'UserController@update')->name('update-user')->middleware(['auth','role:admin|superadmin']);
// Route::delete('/user_delete/{id}', 'UserController@destroy')->name('user-delete')->middleware(['auth','role:admin|superadmin']);

// Route::put('/updateDecompte/{id}', 'MissionController@update_decompte')->name('decompte-update')->middleware(['auth']);


// Route::get('/getUsers', 'UserController@getUsers')->name('getUsers')->middleware(['auth','role:admin|superadmin']);
// Route::get('/getCommuneDistances', 'CommuneDistanceController@getCommuneDistances')->name('getCommuneDistances')->middleware(['auth','role:admin|superadmin']);