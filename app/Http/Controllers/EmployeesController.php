<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeesController extends Controller
	{
		function createEmployee( Request $request )
			{
				$validated = $request->validate( [ 'username' =>'required|unique:employees' ] );

				if ( ! empty( $validated ) )
					{
						$employee = new Employee();

						$employee->status = empty( $request->status ) ? 0 : 1;
						// we can also create a function where we can validate if $request->dept_id exisist in DB to be double sure before any insertion of a foreign key
						$employee->department_id = $request->dept_id;
						$employee->name = $request->name;
						$employee->username = $request->username;
						// Password should never be stored in plain format, so we will encrypt and store it in DB, you may use any other encryption methid like md5 / sha, etc
						$employee->password = bcrypt( $request->password );

						$result = $employee->save();

						if ( $result )
							{
								return [ $this->finalResponse( 'success', 'User created!', 'Pleae login to continue.', [ 'emp_id' => $employee->id ] ) ];
							}
						else
							{
								return [ $this->finalResponse() ];
							}
					}
				else
					{
						return [ $this->finalResponse( 'info', 'User already exists!', 'Please choose a different username.' ) ];
					}
			}
	}