<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentsController extends Controller
	{
		function createDepartment( Request $request )
			{
				// echo 'here';
				// exit();
				// if ( ! $this->doesUserExist( $request->username, $request->secret ) )
				// 	{
				// 		return;
				// 	}

				$department = new Department();

				$department->status = ( $request->status === 0 ) ? 0 : 1;
				$department->name = $request->dept_name;

				try
					{
						$result = $department->save();

						if ( $result )
							{
								return [ $this->finalResponse( 'success', 'Department created successfully!', 'You may now map employees under this department.', [ 'dept_id' => $department->id ] ) ];
							}
						else
							{
								return [ $this->finalResponse( 'error', 'Unable to apply for loan!', '' ) ];
							}
					}
				catch ( Exception $e )
					{
						$this->finalResponse();
					}
			}
	}