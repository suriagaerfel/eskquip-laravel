<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Registration;

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
                $birthdate ='0000-00-00';
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
           

            $stmt = $conn->prepare("SELECT * FROM registrations WHERE registrantId = ?");
            $stmt->execute([$verifyingId]);
            $registration = $stmt->fetch();

            $registrantAccountName = $registration['registrantAccountName'] ?? 'User';
            $registrantCode= $registration['registrantCode'] ?? '';
            $verificationCode= $registration['registrantVerificationCode'] ?? '';

            $mailerBody = <<<END
            <p>Welcome to EskQuip, $registrantAccountName!</p>

            <p>This independent web application developed by Erfel Suriaga, a licensed teacher with a depth passion in learning and innovation, serves as a venue for individuals who aspire to help learners,fellow colleagues and even schools in their educational journey by sharing their articles, ready-made files, researches and online tools. <strong> So, if you are a teacher, writer, editor, school or developer, you are very much welcome!</strong> </p>
                        

            <p>Are you excited to use your account? Verify it now <a href="$publicFolder/verify/$registrantCode/$verificationCode">here</a>.</p>

            <br>
            <p>Best Regards,</p>
            <p>EskQuip Team</p>
            END;

            // 🔥 ACTUALLY SEND EMAIL
            $mailService = new MailService();
            $mailService->send($verifyingEmail, $mailerBody);
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
    

        

        

        
}

