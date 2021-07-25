<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentsController extends Controller
	{
		// This function will create a new department. Post creation of a dept users can be tagged based on their department entry
		function createDepartment( Request $request )
			{
				$department = new Department();

				$department->status = empty( $request->status ) ? 0 : 1;
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
								return [ $this->finalResponse( 'error', 'Unable to create department!', '' ) ];
							}
					}
				catch ( Exception $e )
					{
						$this->finalResponse();
					}
			}
	}