<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$app->post('/Employees', 'authenticateEmployee', function () use ($app) {
    $resDto = new ResponseDto();
    try {
        // get and decode JSON request body
        $request = $app->request();
        $input = json_decode($request->getBody());

        // store Topic record
        $Employee = R::dispense('employees');
       
		
$Employee->firstname = validateInput($input->firstname, 'firstnameRegex');
		$Employee->lastname = validateInput($input->lastname, 'lastnameRegex');
		$Employee->addr = validateInput($input->addr, 'addrRegex');
		$Employee->accountno = validateInput($input->accountno, 'accountnoRegex');
		$Employee->age = validateInput($input->age, 'ageRegex');
		$Employee->email = validateInput($input->email, 'emailRegex');
		
        //$Employee->ownerid = $_SESSION['ids'];
        $Employee->modifiedon = date('Y-m-d G:i:s');
        
        R::store($Employee);

        $resDto->status = TRUE;
        echo upDateResponseDto($resDto);
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});

$app->delete('/Employees/:id', 'authenticateEmployee', function ($id) use ($app) {
    $resDto = new ResponseDto();
    try {
        // query database for Employee
        $request = $app->request();
        // delete Employee
        if ($id != "") {
            R::exec('delete from employees where FIND_IN_SET(id, :id)', array(':id'=> $id));
            // $app->response()->status(204);
            $resDto->status = TRUE;
            echo upDateResponseDto($resDto);
            $resDto = null;
        } else {
            throw new ResourceNotFoundException();
        }
    } catch (ResourceNotFoundException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});


$app->get('/Employees/:id', 'authenticateEmployee', function ($id) use ($app) {
    $resDto = new ResponseDto();
    try {
        // query database for Employee
        $request = $app->request();
        // delete Employee
        if ($id != "") {
            $Employee = R::findOne('employees', 'id=?', array($id));

        // store modified Patient
        // return JSON-encoded response body
        if ($Employee) {
            $app->response()->header('Content-Type', 'application/json');
            echo $Employee;
        }

        } else {
            throw new ResourceNotFoundException();
        }
    } catch (ResourceNotFoundException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});

$app->get('/Employees/:page/:limit', 'authenticateEmployee', function ($page, $limit) use ($app) {
    $resDto = new ResponseDto();
    try {
        $offset = ((int)$page - 1) * (int)$limit;
        if($offset < 0){
            $offset = 0;
        }
    
        // query database for single Employee
        $Employees = R::getAll('select * from employees LIMIT :page, :limit', array(':page'=> $offset, ':limit' => (int)$limit));

        if ($Employees) {
            // if found, return JSON response
            $app->response()->header('Content-Type', 'application/json');
            $json = json_encode($Employees, JSON_NUMERIC_CHECK);
            $json = underscoreToCamelCase($json, 1);
            echo $json;
        } else {
            // else throw exception
            throw new ResourceNotFoundException();
        }
    } catch (ResourceNotFoundException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});

$app->get('/EmployeesCount', 'authenticateEmployee', function () use ($app) {
    $resDto = new ResponseDto();
    try {
        // query database for single Employee
        $EmployeesCount = R::getRow('select count(*) as count from employees');

        if ($EmployeesCount) {
            // if found, return JSON response
            $app->response()->header('Content-Type', 'application/json');
            echo json_encode($EmployeesCount['count'], JSON_NUMERIC_CHECK);
        } else {
            // else throw exception
            throw new ResourceNotFoundException();
        }
    } catch (ResourceNotFoundException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});

$app->put('/Employees/:id', 'authenticateEmployee', function ($id) use ($app) {
    $resDto = new ResponseDto();
    try {
        $request = $app->request();
        $input = json_decode($request->getBody());

        // query database for single Patient
        $Employee = R::findOne('employees', 'id=?', array($id));

        // store modified Patient
        // return JSON-encoded response body
        if ($Employee) {

		
$Employee->firstname = validateInput($input->firstname, 'firstnameRegex');
		$Employee->lastname = validateInput($input->lastname, 'lastnameRegex');
		$Employee->addr = validateInput($input->addr, 'addrRegex');
		$Employee->accountno = validateInput($input->accountno, 'accountnoRegex');
		$Employee->age = validateInput($input->age, 'ageRegex');
		$Employee->email = validateInput($input->email, 'emailRegex');
		
            $Employee->modifiedon = date('Y-m-d G:i:s');
            R::store($Employee);
            $resDto->status = TRUE;

            echo upDateResponseDto($resDto);
            $resDto = null;
        } else {
            throw new ResourceNotFoundException();
        }
    } catch (ResourceNotFoundException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});

$app->get('/Employees/search/like/:data', 'authenticateEmployee', function ($data) use ($app) {
    $resDto = new ResponseDto();
    try {

        // query database for single Jobtitle
        $Employeess = R::getAll('select name, id from Employeess where name LIKE :data', array(':data' => "%".$data."%"));

        if ($Employees) {
            // if found, return JSON response
            $resDto->data = $Employees;
            $app->response()->header('Content-Type', 'application/json');
            echo $resDto;
        } else {
            // else throw exception
            throw new ResourceNotFoundException();
        }
    } catch (ResourceNotFoundException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
        echo upDateResponseDto($resDto);
        $resDto = null;
    }
});


?>
