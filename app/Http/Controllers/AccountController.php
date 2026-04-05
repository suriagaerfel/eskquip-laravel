<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Registration;
use App\Services\AccountRecordsService;
use Illuminate\Support\Facades\Route;

use App\Services\MailService;
use App\Services\FunctionsService;








class AccountController extends Controller
{   
    
     public function create_account(Request $request)
    {
        $currentTime = config('app.currentTime');
        $conn = config('app.conn');

       

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
                $birthdate =null;
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

            $verificationCode = bin2hex(random_bytes(32));
                
            $sql = "INSERT INTO registrations (registrantFirstName, registrantLastName, registrantAccountName,registrantAccountType,registrantBirthdate,registrantGender,registrantEmailAddress,registrantUsername,registrantPassword,registrantBasicAccount,registrantCreatedAt, registrantVerificationCode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);

            $stmt->execute([
                    $firstName,
                    $lastName,
                    $accountName,
                    $type,
                    $birthdate,
                    $gender,
                    $emailAddress,
                    $username,
                    $pwdHash,
                    $basicAccount,
                    $userCreatedAt,
                    $verificationCode
            ]);

            $userId = $conn->lastInsertId();
            
           
                //Add registration code
                $registrantCode = "2026".sprintf("%012d",  4271997+$userId);
             

                $sql = "UPDATE registrations SET registrantCode = ? WHERE registrantId = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$registrantCode, $userId]);
                     

               

                $responses ['registrantFirstName']=$firstName;
                $responses ['registrantLastName']=$lastName;
                $responses ['registrantAccountName']=$accountName;
                $responses ['registrantAccountType']=$type;
                $responses ['registrantBirthdate']=$birthdate;
                $responses ['registrantGender']=$gender;
                $responses ['registrantEmailAddress']=$emailAddress;
                $responses ['registrantUsername']=$username;
                $responses ['registrantPassword']=$pwdHash;
                $responses ['registrantBasicAccount']=$basicAccount;
                $responses ['registrantCreatedAt']=$userCreatedAt;
               

                $responses ['user-id']=$userId;
                $responses ['email-address']=$emailAddress;

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

    public function send_verification_link (Request $request){

            $publicFolder= config('app.publicFolder');
            $conn = config('app.conn');

            //Send verification link
            if ($request->input('send_verification_link_submit')) {
            

            $verifyingId = $request->input('user_id');
            $verifyingEmail = $request->input('email_address');
            $accountAge = $request->input('account_age');
           

            $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantId = ?");
            $stmt->execute([$verifyingId]);
            $registration = $stmt->fetch();

            $registrantAccountName = $registration['registrantAccountName'] ?? 'User';
            $registrantCode= $registration['registrantCode'] ?? '';
            $verificationCode= $registration['registrantVerificationCode'] ?? '';

            $mailerSubject = 'Account Verification';
            $mailerBody = <<<END
            <p>Thank you for registering and welcome to EskQuip, $registrantAccountName!</p>

            <p>An independent web application developed by Erfel Suriaga, a licensed teacher with a depth passion in learning and innovation, EskQuip serves as a venue for individuals who aspire to help learners, fellow colleagues and even schools in their educational journey by sharing articles, ready-made files, researches and online tools. </p>
            
            <p><strong> So, if you are a teacher, writer, editor, school or developer, you are very much welcome here!</strong> </p>
                        

            <p>Are you excited to use your account? Verify it now <a href="$publicFolder/verify/$registrantCode/$verificationCode">here</a>.</p>

             <p>You can also copy the link below and paste it on your browser's url bar if the previous method does not work:</p>

            <p>$publicFolder/verify/$registrantCode/$verificationCode</p>

            <br>
            <p>Best Regards,</p>
            <p>EskQuip Team</p>
            END;

            // 🔥 ACTUALLY SEND EMAIL
            $mailService = new MailService();
            $mailService->send($verifyingEmail, $mailerSubject, $mailerBody);
        }



        

    }



        public function verify ($registrantCode, $verificationCode){
            
        //Verify the account
            $conn = config('app.conn');
            $publicFolder = config('app.publicFolder');


            $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantCode = ?");
            $stmt->execute([$registrantCode]);
            $registration = $stmt->fetch();

            $verificationCodeDatabase= $registration['registrantVerificationCode'] ?? '';

            if ($verificationCode ==  $verificationCodeDatabase) {
                $verificationStatus = "Verified";

                $sql = "UPDATE registrations SET registrantVerificationStatus = ? WHERE registrantCode = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$verificationStatus,$registrantCode]);

                return redirect($publicFolder.'/login');
            } else {
                 return redirect($publicFolder.'/create-account');
            }

         
        
    }


    public function login (Request $request){

        session_start();
       
        //Login
         $conn = config('app.conn');

        if ($request->input('login_submit')) {
            $credential = htmlspecialchars($_POST["login_email_username"]);
            $pwd = htmlspecialchars($_POST["login_password"]);

           
            $responses = [];
            $responses ['error'] = [];


            if ($credential) {

            if ($pwd) {

                        $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantEmailAddress = ? or registrantUsername=?");
                        $stmt->execute([$credential,$credential]);
                        $registrant = $stmt->fetch();


                        if ($registrant) {
                            $registrantId = $registrant ['registrantId'];
                            $registrantCode = $registrant ['registrantCode'];
                            $registrantEmailAddress =  $registrant ['registrantEmailAddress'];
                            $registrantVerificationStatus =  $registrant ['registrantVerificationStatus'];
                            $registrantPassword = $registrant["registrantPassword"];

                            $responses ['user-code'] = $registrantCode;
                            $responses ['user-id'] = $registrantId;
                            $responses ['email-address'] = $registrantEmailAddress;

                            if (password_verify($pwd,$registrantPassword)) {

                                    if ($registrantVerificationStatus=="Verified") {
                                    
                                        //Check login status
                                        $stmt = $conn->prepare("SELECT * FROM registrant_activities WHERE registrant_activityUserId=? ORDER BY registrant_activityId DESC LIMIT 1");
                                        $stmt->execute([$registrantId]);
                                        $login = $stmt->fetch();

                                     


                                        if ($login) {
                                            $loginContent = $login['registrant_activityContent'];

                                            if ($loginContent=='Logged in') {

                                            $error = 'You are logged in in the other device. Log it out now with the link sent to your email address.';
                                            array_push($responses['error'],$error);
                                            $responses ['login-status'] = 'Unsuccessful';
                                            $responses ['logged-in'] = true;
                                        
                                            
                                            } else {
                                                $responses ['logged-in'] = false;
                                                
                                            }


                                        } else {
                                            $responses ['logged-in'] = false;
                                        }

                                            if (!$responses ['logged-in']) {
                                                $activityContent='Logged in';
            
                                                $sql = "INSERT INTO registrant_activities (registrant_activityUserId,registrant_activityContent) VALUES (?,?)";
                                                $stmt = $conn->prepare($sql);

                                                $stmt->execute([
                                                        $registrantId,$activityContent
                                                ]);

                                                
                                                    // $request->session()->put('registrant-code', $registrantCode);
                                                    $session_id= session('id');

                                                    $sql= "UPDATE sessions SET registrant_code = ? WHERE id =  ?";

                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute([$registrantCode,$session_id]);

                                                    session(['registrant_code' => $registrantCode]);
                                                     
                                                    $responses ['login-status'] = 'Successful';
                                                    $responses ['error'] = 'No error';
                                
                                            }



                                    } else {
                                            $error = 'Your account is not yet verified. Verify it now with the link sent to your email address.';
                                            array_push($responses['error'],$error);
                                            $responses ['login-status'] = 'Unsuccessful';
                                            $responses ['unverified'] = true;
                                                
                                    }

                
                            } else {
                                $error = 'Your password is not correct.';
                                array_push($responses['error'],$error);
                                $responses ['login-status'] = 'Unsuccessful';
                                
                            }
                        

                    } else{
                        $error = 'We could not find a record.';
                        array_push($responses['error'],$error);
                        $responses ['login-status'] = 'Unsuccessful';
                        
                    }

                } elseif (!$pwd) {
                    $error = 'Please provide your password.';
                    array_push($responses['error'],$error);

                    $responses ['login-status'] = 'Unsuccessful';
                
                }

            } else {
            $error = 'Please provide your email address or username.';
            array_push($responses['error'],$error);

            $responses ['login-status'] = 'Unsuccessful';

            }

            

            if ($responses) {
                header('Content-Type: application/json');
                $jsonResponses = json_encode($responses,JSON_PRETTY_PRINT);
                echo  $jsonResponses;
            } 
        }   
    }




     public function logout_ajax (Request $request){
            $conn = config('app.conn');
            $registrantId= $request->input('registrant_id');
            $activityContent='Logged out';

            $sql = "INSERT INTO registrant_activities (registrant_activityUserId,registrant_activityContent) VALUES (?,?)";
            $stmt = $conn->prepare($sql);

            $stmt->execute([
                    $registrantId,$activityContent
            ]);

            session()->flush();
          
            $responses = [];
            $responses ['status'] = 'Successful';
            $responses ['success-message'] = 'You have been logged out successfully!';

            if ($responses) {
                header('Content-Type: application/json');
                $jsonResponses = json_encode($responses,JSON_PRETTY_PRINT);
                echo  $jsonResponses;
            }    
     
    }

    public function logout_email ($user_code,$token){
           
           $conn = config('app.conn');
           $publicFolder = config('app.publicFolder');

    
            $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantCode = ?");
            $stmt->execute([$user_code]);
            $user_records = $stmt->fetch();

            $realToken = $user_records ['registrantLogoutLinkToken'];
            $user_id = $user_records ['registrantId'];

            if ($realToken === $token){
                $activityContent='Logged out';

                $sql = "INSERT INTO registrant_activities (registrant_activityUserId,registrant_activityContent) VALUES (?,?)";
                $stmt = $conn->prepare($sql);

                $stmt->execute([
                        $user_id,$activityContent
                ]);


                session()->flush();
                return redirect($publicFolder.'/login');

            } else {
                return redirect($publicFolder.'/create-account');
            }

            
          

       
    }

    public function send_logout_link (Request $request){
        //Send logout link
        if ($request->input('send_logout_link_submit')) {
            $conn = config('app.conn');

            $logoutId = htmlspecialchars($_POST ['user_id']);
            $logoutEmailAddress = htmlspecialchars($_POST['email_address']);
            $publicFolder = config('app.publicFolder');

            $token = bin2hex(random_bytes(32));

            $sql = "UPDATE registrations SET registrantLogoutLinkToken = ? WHERE registrantId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$token, $logoutId]);


            $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantId = ?");
            $stmt->execute([$logoutId]);
            $user_info = $stmt->fetch();

            $user_accountName = $user_info ['registrantAccountName'];
            $user_code = $user_info ['registrantCode'];


            $mailerSubject = 'Logout Account';

            $mailerBody = <<<END
                
                <p>Hi, $user_accountName!</p 
                <p>Someone is attempting to login to your account.</p>
            
                <p>If it's you, kindly click <a href='$publicFolder/logout/$user_code/$token'> here</a> to logout so you can login.</p>

                <p>You can also copy the link below and paste it on your browser's url bar if the previous method does not work:</p>

                <p>$publicFolder/logout/$user_code/$token</p>

                <br><br>
                <p>Best Wishes,</p>
                <p>EskQuip Team</p>


                
                        
            END;

            $mailService = new MailService();
            $mailService->send($logoutEmailAddress, $mailerSubject,$mailerBody);

        }
    }



    public function get_password_reset_link (Request $request){
        //Get reset password link
        if ($request->input('get_password_reset_link_submit')) {

             $conn= config('app.conn');
              $publicFolder = config('app.publicFolder');
            $credential = htmlspecialchars($_POST["credential"]);

            $responses = [];
            $responses ['error'] = [];

            if (empty($credential)) {
                $error = "Please provide your email address or username.";
                array_push($responses ['error'], $error);

            } else {

                $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantEmailAddress = ? or registrantUsername = ?");
                $stmt->execute([$credential,$credential]);
                $registrant = $stmt->fetch();

                if (!$registrant) {
                    $error = "We could not find the record.";
                    array_push($responses ['error'], $error);
                }
            }

            if (!$responses ['error']){

                $receivingEmail = $registrant ['registrantEmailAddress'];
                $userCode = $registrant ['registrantCode'];

                $token = bin2hex(random_bytes(16));

                $tokenHash = hash("sha256",$token);

                $tokenHashExpiration = date("Y-m-d H:i:s",time()+ 60 * 30);

                $stmt = $conn->prepare("UPDATE registrations 
                        SET resetTokenHash = ?,
                            resetTokenHashExpiration = ?
                            WHERE registrantUsername=? or registrantEmailAddress = ?");

                $stmt->execute([$tokenHash,$tokenHashExpiration,$credential,$credential]);


                $mailerSubject = 'Password Reset Link';

                $mailerBody = <<<END
                
                <p>Click <a href='$publicFolder/reset-password/$userCode/$tokenHash'> here </a> to reset your password.</p>
                
                <p>The link will expire after 30 minutes.</p>
           
            END;

                $mailService = new MailService();
                $mailService->send($receivingEmail, $mailerSubject,$mailerBody);


                $responses ['status'] = 'Successful';
                $responses ['success-message'] = 'Password reset link is sent successfully.';

            }  else {
                $responses ['status'] = 'Unsuccessful';
            }

            if ($responses) {
                header('Content-Type: application/json');
                $jsonResponses = json_encode($responses,JSON_PRETTY_PRINT);
                echo  $jsonResponses;
            } 

        }
    }

    //Reset password
    public function reset_password (Request $request){

        $conn=config('app.conn');
        
        if($request->input('reset_password_submit')) {
        
            $userCode = htmlspecialchars($_POST['user_code']);
            $newPassword = htmlspecialchars($_POST['new_password']);
            $newPasswordRetype = htmlspecialchars($_POST['new_password_retype']);

            $responses = [];
            $responses ['error'] = [];



            if (!$newPassword){
                $error = 'Please provide your new password.';
                array_push($responses ['error'], $error);
            } else {
                if (!$newPasswordRetype){
                $error = 'Please retype your new password.';
                array_push($responses ['error'], $error);
                } else {
                    if ($newPassword!==$newPasswordRetype) {
                    $error = 'Passwords do not match.';
                    array_push($responses ['error'], $error); 
                    }
                }
            }


                if (!$responses ['error']) {
                    $pwdHash = password_hash($newPassword, PASSWORD_DEFAULT);   
                   
                    $stmt = $conn->prepare("UPDATE registrations 
                                    SET registrantPassword = ?
                                        WHERE registrantCode = ?");
                    $stmt->execute([$pwdHash,$userCode]);

                    $responses ['status'] = 'Successful';
                    $responses ['success-message'] = 'Password has been reset successfully. You will be redirected to the login page shortly...';
                } 
                    
                else {
                    $responses ['status'] = 'Unsuccessful';
                }


                if ($responses) {
                header('Content-Type: application/json');
                $jsonResponses = json_encode($responses,JSON_PRETTY_PRINT);
                echo  $jsonResponses;
                } 
        

        }
   
    }





    




    

        

        

        
}

