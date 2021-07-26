<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeMeta;

class EmployeesController extends Controller
	{
		// This function will check if a employee exists in DB or not. As we need to perform actions where emp_id is associated so we need to make sure that employee exsists or not
		function employeeExists( $id )
			{
				if ( Employee::find( $id ) )
					{
						return true;
					}
				else
					{
						$this->finalResponse( 'error', 'Employee does not exists!', 'Are you sure you are searching for a correct user?' );
					}
			}

		// This fcuntion will create a new employee
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

						try
							{
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
						catch ( Exception $e )
							{
								$this->finalResponse();
							}
					}
				else
					{
						return [ $this->finalResponse( 'info', 'User already exists!', 'Please choose a different username.' ) ];
					}
			}

		// This function will update details of an employee
		function editEmployeeData( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						echo 'Request reached';
					}
			}

		// This function will display the details of employee and its related meta_data
		function viewEmployeeDetails( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						$id = $request->emp_id;

						return [ Employee::find( $id )->makeHidden( ['password', 'created_at', 'updated_at'] ), [ 'meta_details' =>  EmployeeMeta::select( 'address','contact' )->where( 'employee_id' , $id )->get() ] ];
						
					}
			}

		// This function will delete employee and employee_metadata ( if any )
		function deleteEmployeeData( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						if ( Employee::where( 'id', $request->emp_id )->delete() )
							{
								if ( EmployeeMeta::where( 'employee_id', $request->emp_id )->delete() )
									{
										$this->finalResponse( 'success', 'Employee deleted!', 'Employee data was deleted successfully.' );
									}
								else
									{
										$this->finalResponse( 'warning', 'Unable to delete employee meta data', 'Employee data deleted but unable to delete employee meta data' );
									}
							}
						else
							{
								$this->finalResponse( '', 'Unable to delete employee!', '' );
							}
					}
			}

		// Employee can be searched based on address, contact number, name or username as per the urrent database structure. It can be modified as per needs
		function searchEmployeeData( Request $request )
			{
				$result = Employee::leftJoin( 'employee_metas', 'employees.id', '=', 'employee_metas.employee_id' )->where( 'employees.username', 'like', '%' . $request->search_query . '%' )->
				orWhere( 'employees.name', 'like', '%' . $request->search_query . '%' )->orWhere( 'employee_metas.address', 'like', '%' . $request->search_query . '%' )->orWhere( 'employee_metas.contact', 'like', '%' . $request->search_query . '%' )->select( 'employees.name' )->get();

				if ( ! empty( $result ) )
					{
						$this->finalResponse( 'success', 'Records found!', 'Following are the results', [ 'emp_names' => $result ] );
					}
				else
					{
						$this->finalResponse( 'error', 'No records found!', 'No matching employee records found for ' );
					}
			}

		// This function will create employee meta data ( Address and contact )
		function createEmployeeMetaData( Request $request )
			{
				if ( $this->employeeExists( $request->emp_id ) )
					{
						$employee_meta = new EmployeeMeta();

						$employee_meta->status = empty( $request->status ) ? 0 : 1;
						$employee_meta->employee_id = $request->emp_id;
						$employee_meta->address = $request->address;
						$employee_meta->contact = $request->contact;

						try
							{
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
						catch ( Exception $e )
							{
								$this->finalResponse();
							}
					}
			}
	}