<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class AjaxController extends Controller
{
     public function ajax(Request $request)
    {
       
        $currentTime = config('app.currentTime');

        //for creating account
        if ($request->input('create_account_submit')) {
        
            $type = htmlspecialchars($_POST["create_type"]);
        
            if ($type=="Personal") {
                $firstName = htmlentities($_POST["create_personal_first_name"]);
                $lastName = htmlspecialchars($_POST["create_personal_last_name"]);
                $accountName = $firstName." ".$lastName;
                $birthdate = htmlspecialchars($_POST["create_personal_birthdate"]);
                $gender = htmlspecialchars($_POST["create_personal_gender"]);
                $basicAccount = 'Basic User';
            }



            if ($type=="School") {
                $firstName = "na";
                $lastName = "na";
                $accountName = htmlspecialchars($_POST ['create_school_name']);
                $birthdate = $currentTime;
                $gender = "na";
                $basicAccount = htmlspecialchars($_POST["create_school_basic_account"]);
            }


            $emailAddress = htmlspecialchars($_POST["create_email_address"]);
            $username = htmlspecialchars($_POST["create_username"]);
            $pwd = htmlspecialchars($_POST["create_password"]);
            $pwdRetype = htmlspecialchars($_POST["create_password_retype"]);


            $userCreatedAt = date("Y-m-d H:i:s", $currentTime);
            $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
            $letterOnlyPattern ='/^[a-zA-Z ]+$/';


            $responses = [];
            $responses ['error'] = [];

            if ($type =='Personal') {
                if (!$firstName) {
                    $error= 'First name is required.';
                    array_push($responses ['error'],$error);
                } else {
                    if (!preg_match($letterOnlyPattern,$firstName)) {
                    $error= 'First name is not valid.';
                    array_push($responses ['error'],$error);
                    }
                }

                if (!$lastName) {
                    $error= 'Last name is required.';
                    array_push($responses ['error'],$error);

                } else {
                    if (!preg_match($letterOnlyPattern,$lastName)) {
                    $error= 'Last name is not valid.';
                    array_push($responses ['error'],$error);

                    }
                }

                if (!$birthdate) {
                    $error= 'Birthdate is required.';
                    array_push($responses ['error'],$error);
                }

                if (!$gender) {
                    $error= 'Gender is required.';
                    array_push($responses ['error'],$error);
                }
            }




            if ($type=='School') {
                if (!$accountName) {
                    $error= 'School name is required.';
                    array_push($responses ['error'],$error);
                } else {
                    if (!preg_match($letterOnlyPattern,$accountName)) {
                    $error= 'School name is not valid.';
                    array_push($responses ['error'],$error);
                    }
                }

                if (!$basicAccount) {
                    $error= 'School type is required.';
                    array_push($responses ['error'],$error);
                } 
            }


            if (!$emailAddress) {
                $error= 'Email address is required.';
                array_push($responses ['error'],$error);
            } else {
                if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) { 
                $error= 'Email address is not valid.';
                array_push($responses ['error'],$error);
                } else {
                
                    $existingEmail = Registration::where('registrantEmailAddress',$emailAddress)->first();

                    if ($existingEmail) { 
                    $error= 'Email address is already used.';
                    array_push($responses ['error'],$error);
                    }
                }

            }



            if (!$username) {
                $error= 'Username is required.';
                array_push($responses ['error'],$error);
            } else {
            
                $existingUsername = Registration::where('registrantUsername',$username)->first();

                if ($existingUsername) {
                $error= 'Username is already used.';
                array_push($responses ['error'],$error);
                }
            

            }



            if (!$pwd) {
                $error= 'Password is required.';
                array_push($responses ['error'],$error);
            } else {
                if (strlen($pwd)<8) { 
                $error= 'Password must be at least 8 characters long.';
                array_push($responses ['error'],$error);
                }  

                if (!$pwdRetype) {
                $error= 'Please retype your password.';
                array_push($responses ['error'],$error);
                }
            }

        


            if ($pwd != $pwdRetype) {
                $error= 'Passwords do not match.';
                array_push($responses ['error'],$error);
            }


            if (!$responses ['error']) {
                    
                $newRegistrant = new Registration();
                $newRegistrant->registrantFirstName=$firstName;
                $newRegistrant->registrantLastName=$lastName;
                $newRegistrant->registrantAccountName=$accountName;
                $newRegistrant->registrantAccountType=$type;
                $newRegistrant->registrantBirthdate=$birthdate;
                $newRegistrant->registrantGender=$gender;
                $newRegistrant->registrantEmailAddress=$emailAddress;
                $newRegistrant->registrantUsername=$username;
                $newRegistrant->registrantPassword=$pwdHash;
                $newRegistrant->registrantBasicAccount=$basicAccount;
                $newRegistrant->registrantCreatedAt=$userCreatedAt;
                $newRegistrant->save();

                $userId = $newRegistrant->id();

              
                //Add registration code
                $registrantCode = "2026".sprintf("%012d",  4271997+$userId);
                $registrant = Registration::find($userId);
                $registrant->registrantCode = $registrantCode;
                $registrant->save();


                $responses['status'] = 'Successful';
                $responses ['user-id'] = $userId;
                $responses ['email-address'] = $emailAddress;       

            
                $responses['status'] = 'Successful';
                $responses['success-message'] = 'Your account has been created. Verify it now by the link sent to your email address.';
                
            } else  {
                $responses['status'] = 'Unsuccessful';
            }  

            if ($responses) {
                header('Content-Type: application/json');
                $jsonResponses = json_encode($responses,JSON_PRETTY_PRINT);
                echo $jsonResponses;
            }
            
            
        }
        
    }

        

        

        
}

