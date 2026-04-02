<?php

namespace App\Http\Controllers;



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function  mailer ($verifyingEmail,$mailerBody)
    {
        $mailer = new PHPMailer(true); // Passing `true` enables exceptions

            // Server settings
            // $mailer->isSMTP();
            // $mailer->Host       = env('MAIL_HOST');
            // $mailer->SMTPAuth   = true;//
            // $mailer->Username   = env('MAIL_USERNAME');
            // $mailer->Password   = env('MAIL_PASSWORD');
            // $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mailer->Port       = env('MAIL_PORT', 587);

            

            $mailer->isSMTP();//
            $mailer->Host="smtp.gmail.com";//
            $mailer->SMTPAuth   = true;//
            $mailer->Username = "eskquip@gmail.com";
            $mailer->Password = "aefe osht kypq tyuv"; 
            $mailer->setFrom('eskquip@gmail.com', 'EskQuip');       
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;//
            $mailer->Port= env('MAIL_PORT', 587);//


            // Content
            $mailer->isHTML(true);
            
            

            $mailer->addAddress($verifyingEmail);
            $mailer->Subject = "Account Verification";
        
            $mailer->Body = $mailerBody;
            
           

            try {
                $mailer->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer error: {$mailer->ErrorInfo}"; 
            }

        
    }
}
