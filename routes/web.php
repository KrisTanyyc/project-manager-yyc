<?php


use App\Http\Controllers\Project\Lists\ListProject;
use App\Http\Controllers\Project\Creates\CreateProject;
use App\Http\Controllers\Project\Updates\UpdateProject;
use App\Http\Controllers\Project\Deletes\DeleteProject;

use App\Http\Controllers\User\Lists\ListUser;
use App\Http\Controllers\User\Creates\CreateUser;
use App\Http\Controllers\User\Updates\UpdateUser;
use App\Http\Controllers\User\Deletes\DeleteUser;

use App\Http\Controllers\Role\Lists\ListRole;
use App\Http\Controllers\Role\Creates\CreateRole;
use App\Http\Controllers\Role\Updates\UpdateRole;
use App\Http\Controllers\Role\Deletes\DeleteRole;

use App\Http\Controllers\Action\Creates\CreateAction;
use App\Http\Controllers\Action\Lists\ListAction;
use App\Http\Controllers\Action\Updates\UpdateAction;
use App\Http\Controllers\Action\Deletes\DeleteAction;

use App\Http\Controllers\Module\Creates\CreateModule;
use App\Http\Controllers\Module\Updates\UpdateModule;
use App\Http\Controllers\Module\Deletes\DeleteModule;

use App\Http\Controllers\Authorization\Lists\ListAuthorization;
use App\Http\Controllers\Authorization\Updates\UpdateAuthorization;

use App\Http\Controllers\Stakeholder\Creates\CreateStakeholder;
use App\Http\Controllers\Stakeholder\Updates\UpdateStakeholder;
use App\Http\Controllers\Stakeholder\Deletes\DeleteStakeholder;

use App\Http\Controllers\Snapshot\Creates\CreateSnapshot;
use App\Http\Controllers\Snapshot\Lists\ListSnapshot;
use App\Http\Controllers\Snapshot\Deletes\DeleteSnapshot;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('test',[AuthController::class,'showTest']);

//Login Logout
Route::get('login',[AuthController::class,'create'])->name('login')->middleware('guest');
Route::post('login',[AuthController::class,'store'])->name('login.store');
Route::delete('logout',[AuthController::class,'destroy'])->name('logout');

Route::get('csrf_token', function() {
    return csrf_token();
});



//Admin Panel
Route::middleware(['auth'])->group(function () {
    Route::get('projects',[ListProject::class,'show'])->name('projects.index');
    Route::get('projects/{user_id}/{tab?}',[ListProject::class,'showCertainProject'])->name('project.index');
    Route::get('project/create',[CreateProject::class,'show'])->name('project.create');
    Route::get('project/{user_id}/update',[UpdateProject::class,'show'])->name('projects.update');
    Route::get('project/{user_id}/delete',[DeleteProject::class,'show'])->name('projects.delete');
});



//Module
Route::get('project/{project_id}/module/create',[CreateModule::class,'show'])->name('module.create');
Route::get('project/{project_id}/module/{module_id}/update',[UpdateModule::class,'show'])->name('module.update');
Route::get('project/{project_id}/module/{module_id}/delete',[DeleteModule::class,'show'])->name('module.delete');

//Role
Route::get('roles',[ListRole::class,'show'])->name('roles.index');
Route::get('role/create',[CreateRole::class,'show'])->name('roles.create');
Route::get('role/{role_id}/update',[UpdateRole::class,'show'])->name('roles.update');
Route::get('role/{role_id}/delete',[DeleteRole::class,'show'])->name('roles.delete');

//User
Route::get('users',[ListUser::class,'show'])->name('users.index');
Route::get('user/create',[CreateUser::class,'show'])->name('users.create');
Route::get('user/{user_id}/update',[UpdateUser::class,'show'])->name('users.update');
Route::get('user/{user_id}/delete',[DeleteUser::class,'show'])->name('users.delete');

//User-Role
Route::get('user/{user_id}/roles',[ListUser::class,'showUserRole'])->name('userRole.index');
Route::get('user/{user_id}/roles/assign',[UpdateUser::class,'showAssignRole'])->name('assignRole.index');
Route::get('user/{user_id}/role/{role_id}',[DeleteUser::class,'showDeleteUserRole'])->name('deleteUserRole.index');

//Action
Route::get('/project/{project_id}/module/{module_id}/actions',[ListAction::class,'show'])->name('actions.index');
Route::get('/project/{project_id}/module/{module_id}/action/create',[CreateAction::class,'show'])->name('actions.create');
Route::get('/project/{project_id}/module/{module_id}/action/{action_id}/update',[UpdateAction::class,'show'])->name('actions.update');
Route::get('/project/{project_id}/module/{module_id}/action/{action_id}/delete',[DeleteAction::class,'show'])->name('actions.delete');

//Authorization
Route::get('/project/{project_id}/module/{module_id}/action/{action_id}/authorization',[ListAuthorization::class,'show'])->name('authorization.index');
Route::get('/project/{project_id}/module/{module_id}/action/{action_id}/authorization/edit',[UpdateAuthorization::class,'show'])->name('authorization.update');
Route::get('/project/{project_id}/authorizations/edit',[UpdateAuthorization::class,'showEdit'])->name('authorizations.update');

//Stakeholder
Route::get('/project/{project_id}/stakeholder/create',[CreateStakeholder::class,'show'])->name('stakeholder.create');
Route::get('/project/{project_id}/stakeholder/{stakeholder_id}/update',[UpdateStakeholder::class,'show'])->name('stakeholder.update');
Route::get('/project/{project_id}/stakeholder/{stakeholder_id}/delete',[DeleteStakeholder::class,'show'])->name('stakeholder.delete');

//Snapshot
Route::get('/project/{project_id}/snapshot/create',[CreateSnapshot::class,'show'])->name('snapshot.create');
Route::get('/project/{project_id}/snapshot/{snapshot_id}',[ListSnapshot::class,'show'])->name('snapshot.show');
Route::get('/project/1/snapshot/1/delete',[DeleteSnapshot::class,'show'])->name('snapshot.create');

//Print
Route::get('/print',[ListProject::class,'print']);



