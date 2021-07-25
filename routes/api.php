<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request )
    {
        return $request->user();
    } );

Route::post( 'createdepartment', [ DepartmentsController::class, 'createDepartment' ] );
Route::post( 'createemployee', [ EmployeesController::class, 'createEmployee' ] );