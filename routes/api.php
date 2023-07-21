<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//CRUD for Roles
Route::get('/listRoles',[App\Http\Controllers\Role\Lists\ListRole::class,'list']);
Route::post('/role/create',[App\Http\Controllers\Role\Creates\CreateRole::class,'create']);
Route::put('/updateRole/{role_id}',[App\Http\Controllers\Role\Updates\UpdateRole::class,'update']);
Route::delete('/deleteRole/{role_id}',[App\Http\Controllers\Role\Deletes\DeleteRole::class,'delete']);

//CRUD for Users
Route::get('/listUsers',[App\Http\Controllers\User\Lists\ListUser::class,'list']);
Route::post('/createUsers',[App\Http\Controllers\User\Creates\CreateUser::class,'create']);
Route::put('/updateUser/{user_id}',[App\Http\Controllers\User\Updates\UpdateUser::class,'update']);
Route::get('/listUserCreate',[App\Http\Controllers\User\Creates\CreateUser::class,'listUser']);
Route::delete('/deleteUser/{user_id}',[App\Http\Controllers\User\Deletes\DeleteUser::class,'delete']);

//CRUD for Projects
Route::get('/listProjects',[App\Http\Controllers\Project\Lists\ListProject::class,'list']);
Route::post('/createProject',[App\Http\Controllers\Project\Creates\CreateProject::class,'create']);
Route::put('/updateProject/{project_id}',[App\Http\Controllers\Project\Updates\UpdateProject::class,'update']);
Route::delete('/deleteProject/{project_id}',[App\Http\Controllers\Project\Deletes\DeleteProject::class,'delete']);

//CRUD for Module
Route::get('/project/{project_id}/listModules',[App\Http\Controllers\Module\Lists\ListModule::class,'list']);
Route::post('/project/{project_id}/module/create',[App\Http\Controllers\Module\Creates\CreateModule::class,'create']);
Route::put('/project/{project_id}/module/{module_id}/update',[App\Http\Controllers\Module\Updates\UpdateModule::class,'update']);
Route::delete('/project/{project_id}/module/{module_id}/delete',[App\Http\Controllers\Module\Deletes\DeleteModule::class,'delete']);

//CRUD for Stakeholder
Route::get('/project/{project_id}/listStakeholders',[App\Http\Controllers\Stakeholder\Lists\ListStakeholder::class,'list']);
Route::post('/project/{project_id}/stakeholder/create',[App\Http\Controllers\Stakeholder\Creates\CreateStakeholder::class,'create']);
Route::put('/project/{project_id}/stakeholder/{stakeholder_id}/update',[App\Http\Controllers\Stakeholder\Updates\UpdateStakeholder::class,'update']);
Route::delete('/project/{project_id}/stakeholder/{stakeholder_id}/delete',[App\Http\Controllers\Stakeholder\Deletes\DeleteStakeholder::class,'delete']);

//CRUD for Action
Route::get('/project/{project_id}/module/{module_id}/actions',[App\Http\Controllers\Action\Lists\ListAction::class,'list']);
Route::get('/module/{module_id}/actionBREAD/create',[App\Http\Controllers\Action\Creates\CreateAction::class,'createBREAD']);
Route::post('/module/{module_id}/action/create',[App\Http\Controllers\Action\Creates\CreateAction::class,'create']);
Route::put('/module/{module_id}/action/{action_id}/update',[App\Http\Controllers\Action\Updates\UpdateAction::class,'update']);
Route::delete('/module/{module_id}/action/{action_id}/delete',[App\Http\Controllers\Action\Deletes\DeleteAction::class,'delete']);

//User-Role
Route::get('/displayRolesName',[App\Http\Controllers\RoleToUser\RoleToUserController::class, 'displayRolesName']);
Route::get('/displayListUserRoles/{user_id}',[App\Http\Controllers\RoleToUser\RoleToUserController::class, 'listUserRoles']);
Route::get('/displayAssignRole/{user_id}',[\App\Http\Controllers\RoleToUser\RoleToUserController::class, 'listUserAssignRoles']);
Route::post('/removeUserRole',[App\Http\Controllers\RoleToUser\RoleToUserController::class,'removeUserRole']);
Route::post('/assignUserRole',[App\Http\Controllers\RoleToUser\RoleToUserController::class,'assignUserRole']);

Route::get('/action/{action_id}/authorization',[App\Http\Controllers\Authorization\Lists\ListAuthorization::class,'list']);
Route::post('/action/{action_id}/authorization',[App\Http\Controllers\Authorization\Updates\UpdateAuthorization::class,'update']);
Route::post('/project/{project_id}/authorization/update',[App\Http\Controllers\Authorization\Updates\UpdateAuthorization::class,'updateAll']);

//Change the order of table
Route::post('/stakeholders/order/update',[App\Http\Controllers\Stakeholder\Updates\UpdateStakeholder::class,'orderUpdate']);
Route::post('/modules/order/update',[App\Http\Controllers\Module\Updates\UpdateModule::class,'orderUpdate']);
Route::post('/actions/order/update',[App\Http\Controllers\Action\Updates\UpdateAction::class,'orderUpdate']);
