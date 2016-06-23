<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$app->get('/test/:id', 'authenticate', function ($id) use ($app) {
    echo 'I am working man' + $id;
});

$app->get('/captcha', function () use ($app) {
    $captchanumber = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; // Initializing PHP variable with string
    $imgnumber = substr(str_shuffle($captchanumber), 0, 9); // Getting first 6 word after shuffle.
    
    $_SESSION["code"] = $imgnumber; // Initializing session variable with above generated sub-string

    $im = imagecreatetruecolor(160, 35);
    $bg = imagecolorallocate($im, 115, 135, 157); //background color blue
    $fg = imagecolorallocate($im, 255, 255, 255); //text color white
    imagefill($im, 0, 0, $bg);
    imagestring($im, 15, 15, 15, $_SESSION["code"], $fg);
    header("Cache-Control: no-cache, must-revalidate");
    header('Content-type: image/png');
    imagepng($im);
    imagedestroy($im);
});

$app->post('/signup', function () use ($app) {
    $request = Slim::getInstance()->request();
    $SignUpUser = json_decode($request->getBody());
    $resDto = new ResponseDto();
    
    if ($SignUpUser->captcha && $SignUpUser->captcha != "" && $_SESSION["code"] == $SignUpUser->captcha && $SignUpUser->password == $SignUpUser->confirmPassword) {

        try {
            $value = mt_rand(100000, 999999);
            $random = get_rand_id(10);
            $addurl = get_rand_id(20);
            $urls = get_rand_id(45);

            $user = R::dispense('users');

            
            $user->password = crypt(validateInput($SignUpUser->password, 'password'));
            
            $user->username = validateInput($SignUpUser->email, 'username');
            $user->firstname = validateInput($SignUpUser->firstName, 'firstName');
            $user->lastname = validateInput($SignUpUser->lastName, 'firstName');
            $user->contactno = validateInput($SignUpUser->mobileNumber, 'contactno');
            $user->gender = $SignUpUser->gender;
            $user->address = validateInput($SignUpUser->address, 'address');
            $user->city = validateInput($SignUpUser->city, 'city');
            $user->pincode = validateInput($SignUpUser->pincode, 'pincode');

            $user->lat =$SignUpUser->lat;
            $user->lng = $SignUpUser->lng;

            $user->security_code = $value;
            $user->random_number = $random;

            $userid = R::store($user);

            $userroles = R::dispense('userroles');
            $userroles->userid = $userid;
            if ($SignUpUser->type == "0") {
                $userroles->roleid = 100;
            } else if ($SignUpUser->type == "1") {
                $userroles->roleid = 101;
            } else {
                $userroles->roleid = 100;
            }

            $id = R::store($userroles);



            if ($SignUpUser->type == "0") {
                $empr = R::dispense('employer');
                $empr->company = $SignUpUser->employeedirectory;
                $empr->employerid = $userid;
                R::store($empr);
            } else if ($SignUpUser->type == "1") {
                $emp = R::dispense('employee');
                $emp->skills = $SignUpUser->skills;
                $emp->headline = $SignUpUser->resumeheadline;
                $emp->experience = $SignUpUser->experience;
                $emp->employeeid = $userid;
                R::store($emp);
            }



            $smsdata = R::dispense('smsendsms');

            $smsdata->toid = $userid;

            $smsdata->code = $value;
            $smsdata->smstype = 'register';
            $smsdata->status = 'N';

            R::store($smsdata);

            $to = $SignUpUser->email;
            $subject = "Saisoft-employeedirectory registration verification";
            $message = "<html>
    <body style='margin: 0; padding: 0; width: 100%; height: auto;'>
        <div style='min-height: 100%; position: relative; z-index: 0;'>
            <div style='width: 100%; display: block; width: 99.5%; background-color: #fff; '>
                <div style='min-height: 100%; position: relative; z-index: 0;'>
                    <div><span style='color: #FB7F05; font-size: 24px; font-weight: bolder'>&nbsp;SaiSoft</span> <span style='font-weight: bolder; color: #999; font-size: 24px'>Technologies Pune</span></div>
                    <div style='font-size: 12px'>&nbsp; Deliver Quality Software</div>
                    <div style='font-size: 14px'>&nbsp; jobs@saisoft.co.in</div>
                </div>
            </div>
            <div style='width: 100%; display: block; width: 100%; background-color: cadetblue; 	color: #fff;'>
                <div style='min-height: 100%; position: relative; z-index: 0;'>
                    <center>
                        <h2>*** Greetings From Saisoft Pune ***</h2>
                    </center>
                </div>
            </div>
            <div style='width: 99.5%; display: block; width: 100%; 	height: 25px; 	background-color: #999999; 	color: #fff; padding:9px;'>
                <div style='min-height: 100%; position: relative; z-index: 0;'>
                    <center>
                        <h2 style='color: #fff;font-size: 14px'> SaiSoft employeedirectory Registration </h2>
                    </center>
                </div>
            </div>
 <div style='display: block; float: left; padding-bottom: 70px; border: 2px solid rgb(119, 119, 119); font-family: sans-serif; font-size: 14px; width: 99.1%;'>
                <div style='min-height: 100%; position: relative; z-index: 0; padding: 9px;'>
                    <h4>Welcome to employeedirectory.</h4>
                    &nbsp;
                    
<p style='word-wrap:break-word;'>Hi " . $SignUpUser->firstName . " " . $SignUpUser->lastName . ",</p>
<p style='word-wrap:break-word;'>Greetings from SaiSoft Technologies.</p>
                    <p style='word-wrap:break-word;'>Please click the link given below to activate your account.</p>
<p style='word-wrap:break-word;'>https://www.saisoft.co.in/employeedirectory/login#/verify/fname/" . $SignUpUser->firstName . "/lname/" . $SignUpUser->lastName . "/value/" . $random . "/verifycode/" . $addurl . "/contact/" . $SignUpUser->mobileNumber . "/gender/" . $SignUpUser->gender . "/email/" . $SignUpUser->email . "/urls/" . $urls . "/ids/dhurydh234dudjdjem343Dccdhe4Edr4567Edhdy</p>
                    &nbsp;
                    <p style='word-wrap:break-word;'> Our representative have verified your details and we are processing your verification now. Please check sms for the security code.</p>
<p style='word-wrap:break-word;'>https://www.saisoft.co.in/employeedirectory</p>
                    </div>
           </div> 
            <div  style='background-color: #ccc; padding: 10px; border: 2px solid rgb(119, 119, 119); font-family: sans-serif; font-size: 12px; float: left; height: 10px; width: 99.1%;'>
                <div style='min-height: 100%; position: relative; z-index: 0;'>
                    <center>
                        !!! www.SaiSoft.co.in | jobs@saisoft.co.in | Sadashiv peth | Sangvi | Sinhgad Rd !!! 
                    </center>
                    <center>
                        ***Thank you***
                    </center>
                </div>
            </div> 
            <br/>
    </body>
</html> ";

// To send HTML mail, the Content-type header must be set
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $headers .= 'Bcc: ashutoshzambare@gmail.com' . "\r\n";

            $from = "employeedirectory@saisoft.co.in";
            $headers .= "From:" . $from;

            mail($to, $subject, $message, $headers);
            $resDto->status = TRUE;
            $resDto->errorcode = 0;
            $json = json_encode((array) $resDto);
            $json = str_replace("\u0000ResponseDto\u0000", "", $json);

            //echo $json;
        } catch (PDOException $e) {
            $resDto->status = FALSE;
            $resDto->errorcode = 1;
            $resDto->errorcode = $e->getMessage();
        } catch (Exception $e) {
            $resDto->status = FALSE;
            $resDto->errorcode = 1;
            echo 'Error :' . $e->getMessage();
        } catch (Exception $e) {
            $app->response()->status(404);
        }
    } else {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = "captchaerror";
    }
    $json = json_encode((array) $resDto);
    $json = str_replace("\u0000ResponseDto\u0000", "", $json);

    echo $json;
});


$app->post('/creds', function () use ($app) {
    $request = Slim::getInstance()->request();
    $forgotCreds = json_decode($request->getBody());
    $resDto = new ResponseDto();
    if ($forgotCreds->captcha && $forgotCreds->captcha != "" && $_SESSION["code"] == $forgotCreds->captcha) {
        try {
            $username = $forgotCreds->username;
            $contact = $forgotCreds->contact;
            $user = R::findOne('users', 'username=:username and contactno=:contact', array(':username' => $username, ':contact' => $contact));
            if ($user->enabled == 1 && $user->email_verified == 'Y') {
                $resDto->status = TRUE;
                $resDto->errorcode = 0;
                $smsdata = R::dispense('smsendsms');
                $smsdata->toid = $user->id;
                $smsdata->code = get_rand_id(9);
                $user->password = crypt($smsdata->code);
                $smsdata->smstype = 'forgotcreds';
                $smsdata->status = 'N';
                R::store($user);
                R::store($smsdata);
            } else {
                $resDto->status = FALSE;
                $resDto->errorcode = 1;
            }
        } 
        catch (PDOException $e) {
            $resDto->status = FALSE;
            $resDto->errorcode = 1;
            $resDto->errorcode = $e->getMessage();
        }catch (Exception $e) {
            $resDto->status = FALSE;
            $resDto->errorcode = 1;
            $resDto->errorMessage = $e->getMessage();
        } catch (Exception $e) {
            $app->response()->status(404);
        }
    } else {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = "captchaerror";
    }
    $json = json_encode((array) $resDto);
    $json = str_replace("\u0000ResponseDto\u0000", "", $json);
    echo $json;
});



$app->post('/login', function () use ($app) {
    $request = Slim::getInstance()->request();
    $login = json_decode($request->getBody());
    $resDto = new ResponseDto();
    try {
        $username = validateInput($login->username, 'username');
        $password = validateInput($login->password, 'password');
        //$password = $login->password;

        $user = R::findOne('users', 'username=:username', array(':username' => $username));


        if ($user && (crypt($password, $user->password) == $user->password)) {
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true; //set you've logged in
            $_SESSION['LAST_ACTIVITY'] = time(); //your last activity was now, having logged in.

            $_SESSION['UserID'] = $user->username;
            $_SESSION['LoginID'] = $user->username;
            $_SESSION['ids'] = $user->id;
            $_SESSION['LOGIN_STATUS'] = 'loggedIn';
            $_SESSION['FirstName'] = $user->firstname;
            $_SESSION['LastName'] = $user->lastname;

            if ($user->adminverified == 'Y' and $user->enabled == 1 and $user->email_verified) {
                $resDto->status = TRUE;
                $resDto->errorcode = 0;
                $sql = "SELECT role FROM roles
                      JOIN userroles ON roles.roleid = userroles.roleid
                      JOIN users ON userroles.userid = users.id WHERE username = :username";

                $row = R::getCell($sql, array(':username' => $username));
                $resDto->firstName = $user->firstname;
                $resDto->lastName = $user->lastname;
                $resDto->gender = strtolower($user->gender);

                if ($row == 'employee') {
                    $resDto->target = "employeehome";
                    $_SESSION['LOGIN_EMP'] = 'employeeRole';
                    $resDto->role = "employee";
                } elseif ($row == 'employer') {
                    $resDto->target = "employerhome";
                    $_SESSION['LOGIN_EMPR'] = 'employerRole';
                    $resDto->role = "employer";
                } elseif ($row == 'admin') {
                    $resDto->target = "adminhome";
                    $resDto->role = "admin";
                    $_SESSION['LOGIN_ADM'] = 'adminRole';
                }

                $employeedirectoryId = get_rand_id(25);
                $employeedirectoryKey = get_rand_id(33);
                $xsrf = get_rand_id(27);
                $_SESSION['employeedirectoryId'] = $employeedirectoryId;
                $_SESSION['employeedirectoryKey'] = $employeedirectoryKey;
                $_SESSION['xsrf'] = $xsrf;


                Slim::getInstance()->setEncryptedCookie('employeedirectoryId', $employeedirectoryId, '60 minutes');
                Slim::getInstance()->setEncryptedCookie('employeedirectoryKey', $employeedirectoryKey, '60 minutes');
                Slim::getInstance()->setCookie('XSRF-TOKEN', $xsrf, '60 minutes');
                Slim::getInstance()->setCookie('homeroleuser', $resDto->target, '60 minutes');
            } else {
                $resDto->status = FALSE;
                $resDto->errorcode = 1;
                $resDto->errorMessage = "activate";
            }
        } else {
            $resDto->status = FALSE;
            $resDto->errorcode = 1;
        }
        $db = null;
    } catch (PDOException $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorMessage = $e->getMessage();
    } catch (Exception $e) {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->errorcode = $e->getMessage();
    }catch (Exception $e) {
            $app->response()->status(404);
        }
    $json = json_encode((array) $resDto);
    $json = str_replace("\u0000ResponseDto\u0000", "", $json);
    echo $json;
});



$app->get('/logout', function() use ($app) {

    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
    }

    $resDto = new ResponseDto();
    unset($_SESSION['UserID']);
    unset($_SESSION['EmailAddress']);
    unset($_SESSION['LoginID']);
    unset($_SESSION['GoldMember']);
    unset($_SESSION['LOGIN_STATUS']);


    session_destroy();


    $resDto->status = TRUE;
    $resDto->errorcode = 0;
    $resDto->target = "login";
    $json = json_encode((array) $resDto);
    $json = str_replace("\u0000ResponseDto\u0000", "", $json);

    echo $json;
});

$app->POST('/user', 'authenticate', function () use ($app) {
    $userId = $_SESSION['UserID'];
    try {
        $user = R::findOne('users', 'UserID=:userId', array(':userId' => $userId));
        if ($user) {
            echo $user;
        } else {
            echo "error";
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
});

$app->get('/isUserLoggedIn', 'authenticateEmployee', function () use ($app) {
    $resDto = new ResponseDto();
    if ((isset($_SESSION['ids'])) && isset($_SESSION['LOGIN_STATUS'])) {
        $resDto->status = true;
        $resDto->errorcode = 0;
        $resDto->target = "home";
    } else {
        $resDto->status = FALSE;
        $resDto->errorcode = 1;
        $resDto->target = "login";
    }
    $json = json_encode((array) $resDto);
    $json = str_replace("\u0000ResponseDto\u0000", "", $json);

    echo $json;
});
?>
