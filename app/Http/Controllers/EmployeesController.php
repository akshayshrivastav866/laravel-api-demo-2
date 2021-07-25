<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeMeta;

class EmployeesController extends Controller
	{
		function employeeExists( $id )
			{
				if ( Employee::find( $id ) )
					{
						return true;
					}
				else
					{
						$this->finalResponse();
					}
			}

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

		function createEmployeeMetaData( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						$employee_meta = new EmployeeMeta();

						$employee_meta->status = empty( $request->status ) ? 0 : 1;
						$employee_meta->employee_id = $request->emp_id;
						$employee_meta->address = $request->address;
						$employee_meta->contact = $request->contact;

						$result = $employee_meta->save();

						if ( $result )
							{
								return [ $this->finalResponse( 'success', 'User meta saved!', 'Your address and contact have been saved sucessfully.' ) ];
							}
						else
							{
								return [ $this->finalResponse() ];
							}
					}
				else
					{
						$this->finalResponse( '', 'Invalid employee request!', 'Are you sure you are searching for a correct employee?' );
					}
			}

		function viewEmployeeDetails( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						return [ $existence_result->makeHidden( ['password', 'created_at', 'updated_at'] ), [ 'meta_details' =>  EmployeeMeta::select( 'address','contact' )->where( 'employee_id' , $request->emp_id )->get() ] ];
						
					}
				else
					{
						$this->finalResponse( 'error', 'User does not exists!', 'Are you sure you are searching for a correct user?' );
					}
			}

		function deleteEmployeeData( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						echo 'here';
					}
			}
	}