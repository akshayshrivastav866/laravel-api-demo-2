### **Laravel API Demo App**

**Version** 8.5

This app is a demo API app that will give you an idea of the working of APIs in Laravel ( Post and GET ).

### **Database setup**

Please open your localhost phpmyadmin / adminer, etc.

Navigate to folder SQL Schema File in this project and you will find a file named `records_test.sql`. Import that SQL file in you DBs list

### **Request Format and type**

If you are using POSTMAN. Please follow the below process

1. Set request type to `POST`or `GET` as defined below
2. Set your base request URL
3. Select body and then select x-www-form-urlencoded
4. Below are list of APIs with required fields

### **List of APIs**

PN: My local server was http://127.0.0.1:9090 You may change the settings as per you laravel environment

1. http://127.0.0.1:9090/api/createdepartment ( Request type: `POST` )
2. http://127.0.0.1:9090/api/createemployee ( Request type: `POST` )
3. http://127.0.0.1:9090/api/viewemployee/<employee_id> ( Request type: `GET` )
4. http://127.0.0.1:9090/api/createemployeemeta ( Request type: `POST` )
5. http://127.0.0.1:9090/api/deleteemployee ( Request type: `POST` )
5. http://127.0.0.1:9090/api/searchemployee ( Request type: `POST` )
5. http://127.0.0.1:9090/api/editemployee ( Request type: `POST` )

### **Application Flow**

PN: You will receive JSON responses to every API request

1. You are a new user so visit `/api/createdepartment`to create a department first. Fields required for this request are `status` & `dept_name`

    Expected Response: `{"status":"success","heading":"Department created successfully!","message":"You may now map employees under this department.","data":{"dept_id":<your_dept_id_here>}}`

2. You need to now login so visit `/api/createemployee`. Fields required for this request are `status`, `dept_id`( this will be yeilded from the response of first api call in step 1 ), `name`, `username`, & `password`( Pls note your password will be encrypted so kindly memorize it )

    Expect Response: `{"status":"success","heading":"User created!","message":"Pleae login to continue.","data":{"emp_id":<your_emp_id_here>}}`

3. If you want to view any employee data you may do so by visiting `api/viewemployee/<employee_id>` Please send  `employee_id` that we received in step 2

    Expected Response: `[
    {
        "id": 1,
        "status": 1,
        "department_id": 3,
        "name": "<name_here>",
        "username": "<username_here>"
    },
    {
        "meta_details": [
            {
                "address": "<address_here>",
                "contact": "<number_here>"
            },
            {
                "address": "<address_here>",
                "contact": "<number_here>"
            }
        ]
    }
]`

4. If you want to add meta data for employee like address / contact you may head to `/api/createemployeemeta` Fields required for this request are `emp_id`, `status`, `contact` & `address`

    Expected Response: `{"status":"success","heading":"User meta saved!","message":"Your address and contact have been saved sucessfully."}`

5. If you want to delete data for an employee you may head to `/api/deleteemployee` Fields required for this request are `emp_id`

	Expected Response: `{"status":"success","heading":"Employee deleted!","message":"Employee data was deleted successfully."}`

6. If you want to search data for an employee you may head to `/api/searchemployee` Fields required for this request are `search_query`

    Expected Response: `{"status":"success","heading":"Records found!","message":"Following are the results","data":{"emp_names":[{"name":"<emp_name>"},{"name":"<emp_name>"}]}}`

7. If you want to edit data for an employee you may head to `/api/editemployee` Fields required for this request are `emp_id`& `name`

    Expected Response: `{"status":"success","heading":"Record updated!","message":"Employee data has been updated successfully."}`