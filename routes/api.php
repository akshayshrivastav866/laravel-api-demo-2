<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request )
    {
        return $request->user();
    } );

/* Create department section, an employee can be only create if an if a department exists */
Route::post( 'createdepartment', [ DepartmentsController::class, 'createDepartment' ] );

/* Employee creation, view, delete, search section */
Route::post( 'createemployee', [ EmployeesController::class, 'createEmployee' ] );
Route::get( 'viewemployee/{emp_id}', [ EmployeesController::class, 'viewEmployeeDetails' ] );
Route::post( 'deleteemployee', [ EmployeesController::class, 'deleteEmployeeData' ] );
Route::post( 'searchemployee', [ EmployeesController::class, 'searchEmployeeData' ] );

/* Create employee meta data section ( Multiple Address, contact for an employee ) */
Route::post( 'createemployeemeta', [ EmployeesController::class, 'createEmployeeMetaData' ] );