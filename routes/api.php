<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request )
    {
        return $request->user();
    } );

// For post related requests
Route::post( 'createdepartment', [ DepartmentsController::class, 'createDepartment' ] );
Route::post( 'createemployee', [ EmployeesController::class, 'createEmployee' ] );
Route::post( 'createemployeemeta', [ EmployeesController::class, 'createEmployeeMetaData' ] );
Route::post( 'deleteemployee', [ EmployeesController::class, 'deleteEmployeeData' ] );

// For get realted requests
Route::get( 'viewemployee/{emp_id}', [ EmployeesController::class, 'viewEmployeeDetails' ] );