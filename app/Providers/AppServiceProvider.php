<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use PSpell\Config;

use PDO;
use Illuminate\Foundation\AliasLoader;
use App\Services\MyInitialRecordsService;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        $this->app->bind('appConfig', function () {
        return [
            'site_name' => 'My App',
            'admin_email' => 'admin@example.com'
        ];
        });

      

    
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(Request $request, MyInitialRecordsService $service)
    {

        require_once app_path('Helpers/helpers.php');

        //    $this->app->singleton(MyInitialRecordsService::class, function ($app) {
        //         return new MyInitialRecordsService();
        // });

       

        //------------------------------------------DATABASE CONNECTION-----------------------------------//
        $conn = DB::connection('mysql')->getPdo();
        config(['app.conn' => $conn]);


        //------------------------------------------DYNAMIC HOST-----------------------------------//


        $domain = $request->schemeAndHttpHost();

        if ($domain) {

            if ($domain)
            $publicFolder= $domain; 
            $privateFolder=$domain.'/private';

            if(str_contains($domain,'localhost')){
                $projectName = '/eskquip-laravel';
                $domain = $domain.$projectName;

                $publicFolder= $domain.'/public'; 
                $privateFolder=$domain.'/private';

                config(['app.publicFolder'=>$publicFolder]);
                config(['app.privateFolder'=>$privateFolder]);

                View::share('publicFolder',$publicFolder);
                View::share('privateFolder',$privateFolder);
            }

        }



        


        //------------------------------------------ACCESSED USER-----------------------------------//
        $user= isset($_GET['user']) ? htmlspecialchars(isset($_GET['user'])) : '';
        config(['app.user'=>$user]);



        //------------------------------------------SLUG-----------------------------------//
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        config(['app.slug'=>$slug]);



        //----------------------------------------TIME ZONE and CURRENT TIME----------------------------------//

        date_default_timezone_set('Asia/Manila');

        $currentTimeZone = date_default_timezone_get();
        $currentTime = time(); 

        $currentTimeConverted = date("m/d/Y g:i A",  $currentTime); 


        config(['app.currentTimeZone' => $currentTimeZone]);
        config(['app.currentTime'=> $currentTime]);
        config(['app.currentTimeConverted'=>$currentTimeConverted]);

        // //---------------------------------------- SESSION ID ---------------------------------//

        
        // $registrantId= isset($_SESSION['id']) ? $_SESSION['id'] : ''; 
        // $loggedIn =  false;

        // // $registrantId= 1; 
        

        //         config(['app.registrantId' => $registrantId]);
        //         config(['app.loggedIn' => $loggedIn]);



        // ------------------------------------------- CURRENT URL ------------------------------------------//
        $currentURL = request()->url();
        config(['app.currentURL' => $currentURL]);


       

       

  
// // ------------------------------------ REGISTRANT RECORDS ------------------------------------------//

//         $registrantCode = '';
         
//         $firstName = '';
//         $middleName = '';
//         $lastName = '';
//         $accountName = '';
//         $registrantDescription = '';
//         $type = '';

//         $username = '';
//         $emailAddress = '';
//         $mobileNumber = '';

//         $birthdate = '';
//         $gender = '';
//         $civilStatus = '';

//         $profilePictureLink = '';
//         $coverPhotoLink='';
//         $education = '';
//         $school = '';
//         $occupation = '';

//         $street_subd_village = '';
//         $barangay = '';
//         $city_municipality = '';
//         $province_state = '';
//         $region='';
//         $country = '';
//         $zipcode = '';

//         $basicRegistration = '';
//         $teacherRegistration = '';
//         $writerRegistration = '';
//         $editorRegistration = '';
//         $websiteManagerRegistration = '';
//         $developerRegistration = '';
//         $researchesRegistration='';
//         $websiteManagerRegistration='';

//         $websiteManagerSuperManagerRegistration='';
//         $websiteManagerSubscriptionManagerRegistration='';
//         $websiteManagerRegistrationManagerRegistration='';
//         $websiteManagerPromotionManagerRegistration='';
//         $websiteManagerMessageManagerRegistration='';


//         $inSubscriptionSellerList='';
//         $inSubscriptionToolList='';
//         $inSubscriptionFileList='';
//         $inSubscriptionShelfList='';

//         $toolSubscribed=false; 
//         $fileSubscribed=false; 
//         $sellerSubscribed=false;
//         $shelfSubscribed=false; 

//         $pendingToolSubscription=false;
//         $pendingFileSubscription=false;
//         $pendingSellerSubscription=false;
//         $pendingShelfSubscription=false;

//         $subscriptionRemainingDaysTool = '';
//         $subscriptionRemainingDaysFile='';
//         $subscriptionRemainingDaysSeller='';
//         $subscriptionRemainingDaysShelf='';


//         $haveOtherRegistration = false;
//         $haveAllRegistrations=false;

    
//         $filledOutSellingDetails="";

//         $subscription='';
   

// if ($registrantId) {


//                 $myRecords = DB::table('registrations')
//                 ->where('registrantId',$registrantId)
//                 ->first();


//                 //     return $myRecords;
//                     if ($myRecords){
//                         $loggedIn = true;
//                         $registrantCode = $myRecords->registrantCode;
//                         $firstName = $myRecords->registrantFirstName;
//                         $middleName = $myRecords->registrantMiddleName;
//                         $lastName = $myRecords->registrantLastName;
//                         $type = $myRecords->registrantAccountType;
//                         $accountName = $myRecords->registrantAccountName;
//                         $registrantDescription = $myRecords ->registrantDescription;

//                         $username = $myRecords->registrantUsername;
//                         $emailAddress = $myRecords->registrantEmailAddress;
//                         $mobileNumber = $myRecords->registrantMobileNumber;

//                         $birthdate = $myRecords->registrantBirthdate;
//                         $gender = $myRecords->registrantGender;
//                         $civilStatus = $myRecords->registrantCivilStatus;

//                         $education = $myRecords->registrantEducationalAttainment;
//                         $school = $myRecords->registrantSchool;
//                         $occupation = $myRecords->registrantOccupation;

//                         $street_subd_village = $myRecords ->registrantAddressStreet;
//                         $barangay = $myRecords ->registrantAddressBarangay;
//                         $city_municipality = $myRecords ->registrantAddressCity;
//                         $province_state = $myRecords ->registrantAddressProvince;
//                         $region = $myRecords ->registrantAddressRegion;
//                         $country = $myRecords ->registrantAddressCountry;
//                         $zipcode = $myRecords ->registrantAddressZipCode;

//                         $paymentChannel = $myRecords ->registrantPaymentChannel;
//                         $bankAccountName = $myRecords ->registrantBankAccountName;
//                         $bankAccountNumber = $myRecords ->registrantBankAccountNumber;
//                         $reviewSchedules = $myRecords ->registrantReviewSchedules;



//                         if ($paymentChannel && $bankAccountName && $bankAccountNumber && $reviewSchedules) {
//                             $filledOutSellingDetails = "yes";
//                         } 
                    

//                         $profilePictureLink = $myRecords->registrantProfilePictureLink ? asset($myRecords->registrantProfilePictureLink) : asset("/images/user.svg");

//                         $coverPhotoLink = $myRecords->registrantCoverPhotoLink ? asset($myRecords->registrantCoverPhotoLink) : asset("/images/cover-photo.jpeg");

//                         $basicRegistration = $myRecords->registrantBasicAccount;
//                         $teacherRegistration = $myRecords->registrantTeacherAccount;
//                         $writerRegistration = $myRecords->registrantWriterAccount;
//                         $editorRegistration = $myRecords->registrantEditorAccount;
//                         $websiteManagerRegistration = '';
//                         $developerRegistration = $myRecords->registrantDeveloperAccount;
//                         $researchesRegistration = $myRecords->registrantResearchesAccount; 

                       

//                          $websiteManagerRegistrations = DB::table('website_manager_accounts')
//                         ->where('website_manager_accountRegistrant',$registrantId)
//                         ->first();

//                             if ($websiteManagerRegistrations){
//                                     $websiteManagerSuperManagerRegistration = $websiteManagerRegistrations->website_manager_accountSuperManager;

//                                     $websiteManagerSubscriptionManagerRegistration = $websiteManagerRegistrations->website_manager_accountSubscriptionManager;

//                                     $websiteManagerRegistrationManagerRegistration = $websiteManagerRegistrations->website_manager_accountRegistrationManager;

//                                     $websiteManagerPromotionManagerRegistration = $websiteManagerRegistrations->website_manager_accountPromotionManager;

//                                     $websiteManagerMessageManagerRegistration = $websiteManagerRegistrations->website_manager_accountMessageManager;
                                
//                                     if ($websiteManagerSuperManagerRegistration ||            $websiteManagerSubscriptionManagerRegistration || $websiteManagerRegistrationManagerRegistration || $websiteManagerPromotionManagerRegistration || $websiteManagerMessageManagerRegistration){
//                                         $websiteManagerRegistration = 'Website Manager';
//                                     }


//                                     $websiteManagerRegistrationsComplete = [];

//                                     if ($websiteManagerSuperManagerRegistration){
//                                         array_push($websiteManagerRegistrationsComplete,$websiteManagerSuperManagerRegistration);
//                                     }

//                                     if ($websiteManagerSubscriptionManagerRegistration){
//                                         array_push($websiteManagerRegistrationsComplete,$websiteManagerSubscriptionManagerRegistration);
//                                     }

//                                     if ($websiteManagerRegistrationManagerRegistration){
//                                         array_push($websiteManagerRegistrationsComplete,$websiteManagerRegistrationManagerRegistration);
//                                     }

//                                     if ($websiteManagerPromotionManagerRegistration){
//                                         array_push($websiteManagerRegistrationsComplete,$websiteManagerPromotionManagerRegistration);
//                                     }

//                                     if ($websiteManagerMessageManagerRegistration){
//                                         array_push($websiteManagerRegistrationsComplete,$websiteManagerMessageManagerRegistration);
//                                     }

//                                     if ($websiteManagerRegistrationsComplete) {
//                                         $websiteManagerRegistrationsComplete = implode(', ', $websiteManagerRegistrationsComplete);
//                                     }


                                    
//                         }

//                         $registrations = [];
                    
//                             if ($basicRegistration) {
//                                 array_push($registrations,$basicRegistration);
//                             }

//                             if ($teacherRegistration) {
//                                 array_push($registrations,$teacherRegistration);
//                             }

//                             if ($writerRegistration) {
//                                 array_push($registrations,$writerRegistration);
//                             }
//                             if ($editorRegistration) {
//                                 array_push($registrations,$editorRegistration);
//                             }

//                             if ($developerRegistration) {
//                                 array_push($registrations,$developerRegistration);
//                             }

//                             if ($websiteManagerRegistration) {
//                                 array_push($registrations,$websiteManagerRegistration);
//                             }         

                        


                            


//                             if ($registrations) {
//                                 $registrations = implode(' | ', $registrations);
//                             }

//                         if ($teacherRegistration || $writerRegistration || $editorRegistration || $websiteManagerRegistration ||  $developerRegistration || $researchesRegistration) {
//                         $haveOtherRegistration = true;
//                         }


//                         if ($teacherRegistration && $writerRegistration && $editorRegistration && $websiteManagerRegistration &&  $developerRegistration) {
//                         $haveAllRegistrations = true;
//                         } 
                




//                         //Check tool subscription                       
//                         $inSubscriptionToolList = DB::table('registrant_subscriptions')
//                         ->where('registrant_subscriptionUserId',$registrantId)
//                         ->where('registrant_subscriptionType','Tools')
//                         ->orderBy('registrant_subscriptionId','desc')
//                         ->first();

//                         if ($inSubscriptionToolList) {
//                             $subscriptionStatusTool = $inSubscriptionToolList->registrant_subscriptionStatus;
//                             $subscriptionExpiryTool = dcomplete_format($inSubscriptionToolList->registrant_subscriptionExpiry);

//                             $subscriptionRemainingDaysTool = floor((strtotime($subscriptionExpiryTool) - $currentTime)/86400);
                            
//                             $inSubscriptionToolList="yes";

                        
//                             if ($subscriptionStatusTool == 'Approved' || $subscriptionStatusTool == 'Kept' || $subscriptionStatusTool == 'Revoked') {
//                             if (strtotime($subscriptionExpiryTool)-$currentTime>0) {
//                                 $_SESSION ['tool-subscribed'] = "yes";
//                                 $toolSubscribed=true;    
//                             }
                        
//                             }

//                             elseif ($subscriptionStatusTool == 'Pending') {
//                             $_SESSION ['pending-tool-subscription'] = "yes";
//                             $pendingToolSubscription=true;

//                         }     
                    
//                         }

//                         //Check file subscription
//                         $inSubscriptionFileList = DB::table('registrant_subscriptions')
//                         ->where('registrant_subscriptionUserId',$registrantId)
//                         ->where('registrant_subscriptionType','Files')
//                         ->orderBy('registrant_subscriptionId','desc')
//                         ->first();


//                         if ($inSubscriptionFileList) {
//                             $subscriptionStatusFile = $inSubscriptionFileList->registrant_subscriptionStatus;
//                             $subscriptionExpiryFile = dcomplete_format($inSubscriptionFileList->registrant_subscriptionExpiry);

//                             $subscriptionRemainingDaysFile = floor((strtotime($subscriptionExpiryFile) - $currentTime)/86400);

//                             $inSubscriptionFileList="yes";

                        
//                             if ($subscriptionStatusFile == 'Approved' || $subscriptionStatusFile == 'Kept' || $subscriptionStatusFile == 'Revoked') {
//                                 if (strtotime($subscriptionExpiryFile)-$currentTime>0) {
//                                     $_SESSION ['file-subscribed'] = "yes";
//                                     $fileSubscribed=true;    
//                                 }
//                             }

//                             elseif ($subscriptionStatusFile == 'Pending') {
//                             $_SESSION ['pending-file-subscription'] = "yes";
//                             $pendingFileSubscription=true;

//                         }     
                    
//                         }




//                         //Check seller subscription
//                         $inSubscriptionSellerList = DB::table('registrant_subscriptions')
//                         ->where('registrant_subscriptionUserId',$registrantId)
//                         ->where('registrant_subscriptionType','Seller')
//                         ->orderBy('registrant_subscriptionId','desc')
//                         ->first();


//                         if ($inSubscriptionSellerList) {
//                             $subscriptionStatusSeller = $inSubscriptionSellerList->registrant_subscriptionStatus;
//                             $subscriptionExpirySeller = dcomplete_format($inSubscriptionSellerList->registrant_subscriptionExpiry);

//                             $subscriptionRemainingDaysSeller = floor((strtotime($subscriptionExpirySeller) - $currentTime)/86400);

//                             $inSubscriptionSellerList="yes";

                        
//                             if ($subscriptionStatusSeller == 'Approved' || $subscriptionStatusSeller == 'Kept' || $subscriptionStatusSeller == 'Revoked') {

//                                 if (strtotime($subscriptionExpirySeller)-$currentTime>0) {
//                                         $_SESSION ['seller-subscribed'] = "yes";
//                                         $sellerSubscribed=true;    
//                                 }
                        
//                             } elseif ($subscriptionStatusSeller == 'Pending') {
//                             $_SESSION ['pending-seller-subscription'] = "yes";
//                             $pendingSellerSubscription=true;

//                         }     
                    
//                         }

//                         //Check shelf subscription
//                       $inSubscriptionShelfList = DB::table('registrant_subscriptions')
//                         ->where('registrant_subscriptionUserId',$registrantId)
//                         ->where('registrant_subscriptionType','Shelf')
//                         ->orderBy('registrant_subscriptionId','desc')
//                         ->first();


//                         if ($inSubscriptionShelfList) {
//                             $subscriptionStatusShelf = $inSubscriptionShelfList->registrant_subscriptionStatus;

//                             $subscriptionExpiryShelf = dcomplete_format($inSubscriptionShelfList->registrant_subscriptionExpiry);

//                             $subscriptionRemainingDaysShelf = floor((strtotime($subscriptionExpiryShelf) - $currentTime)/86400);

//                             $inSubscriptionShelfList="yes";

                        
//                             if ($subscriptionStatusShelf == 'Approved' || $subscriptionStatusShelf == 'Kept' || $subscriptionStatusShelf == 'Revoked') {
//                                 if (strtotime($subscriptionExpiryShelf)-$currentTime>0){
//                                     $_SESSION ['shelf-subscribed'] = "yes";
//                                     $shelfSubscribed=true;    
//                                 }
//                             }

//                             elseif ($subscriptionStatusShelf == 'Pending') {
//                             $_SESSION ['pending-shelf-subscription'] = "yes";
//                             $pendingShelfSubscription=true;

//                         }     
                    
//                         }

//                         if ($type=='Personal') {
//                             if ($teacherRegistration) {
//                                 if ($inSubscriptionToolList && $inSubscriptionSellerList) {
//                                 $subscription = "disabled";
//                                 } 
//                             }

//                             if (!$teacherRegistration) {
//                                 if ($inSubscriptionToolList) {
//                                 $subscription = "disabled";
//                                 } 
//                             }
//                         }
                        
//                         if ($type=='School') {
//                             if ($inSubscriptionShelfList) {
//                             $subscription = "disabled";
//                             }
//                         }
                        


//                         //Check login status
                        

//                         $lastLog = DB::table('registrant_activities')
//                         ->where('registrant_activityUserId',$registrantId)
//                         ->orderBy('registrant_activityId','desc')
//                         ->first();

//                         if ($lastLog) {
//                         $lastLogContent =$lastLog->registrant_activityContent;

//                         } 



//                     } 

                   
                        
     
                    
// } 




// config([
         
//         'registrantId' => $registrantId,
//          'registrantCode'=>$registrantCode,
//          'loggedIn'=> $loggedIn,
//          'publicFolder'=>$publicFolder,
//          'privateFolder'=>$privateFolder,
//          'currentTime'=>$currentTime,
//          'firstName'=>$firstName,
//          'middleName'=>$middleName,
//          'lastName'=>$lastName,
//          'accountName'=>$accountName,
//          'registrantDescription'=>$registrantDescription,
//          'type'=>$type,
//          'username'=>$username,
//          'emailAddress'=>$emailAddress,
//          'mobileNumber'=>$mobileNumber,
//          'birthdate'=>$birthdate,
//          'gender'=>$gender,
//          'civilStatus'=>$civilStatus,
//          'profilePictureLink'=>$profilePictureLink,
//          'coverPhotoLink'=>$coverPhotoLink,
//          'education'=>$education,
//          'school'=>$school,
//          'occupation'=>$occupation,
//          'street_subd_village'=>$street_subd_village,
//          'barangay'=>$barangay,
//          'city_municipality'=>$city_municipality,
//          'province_state'=>$province_state,
//          'region'=>$region,
//          'country'=>$country,
//          'zipcode'=>$zipcode,
//          'basicRegistration'=>$basicRegistration,
//          'teacherRegistration'=>$teacherRegistration,
//          'writerRegistration'=>$writerRegistration,
//          'editorRegistration'=>$editorRegistration,
//          'websiteManagerRegistration'=>$websiteManagerRegistration,
//          'developerRegistration'=>$developerRegistration,
//          'researchesRegistration'=>$researchesRegistration,
//          'websiteManagerSuperManagerRegistration'=>$websiteManagerSuperManagerRegistration,
//          'websiteManagerSubscriptionManagerRegistration'=>$websiteManagerSubscriptionManagerRegistration,
//          'websiteManagerRegistrationManagerRegistration'=>$websiteManagerRegistrationManagerRegistration,
//          'websiteManagerPromotionManagerRegistration'=>$websiteManagerPromotionManagerRegistration,
//          'websiteManagerMessageManagerRegistration'=>$websiteManagerMessageManagerRegistration,
//          'inSubscriptionSellerList'=>$inSubscriptionSellerList,
//          'inSubscriptionToolList'=>$inSubscriptionToolList,
//          'inSubscriptionFileList'=>$inSubscriptionFileList,
//          'inSubscriptionShelfList'=>$inSubscriptionShelfList,
//          'toolSubscribed'=>$toolSubscribed,
//          'fileSubscribed'=>$fileSubscribed,
//          'sellerSubscribed'=>$sellerSubscribed,
//          'shelfSubscribed'=>$shelfSubscribed,
//          'pendingToolSubscription'=>$pendingToolSubscription,
//          'pendingFileSubscription'=>$pendingFileSubscription,
//          'pendingSellerSubscription'=>$pendingSellerSubscription,
//          'pendingShelfSubscription'=>$pendingShelfSubscription,

//          'subscriptionRemainingDaysTool' => $subscriptionRemainingDaysTool,
//         'subscriptionRemainingDaysFile'=>$subscriptionRemainingDaysFile,
//         'subscriptionRemainingDaysSeller'=>$subscriptionRemainingDaysSeller,
//         'subscriptionRemainingDaysShelf'=>$subscriptionRemainingDaysShelf,
//         'subscription'=>$subscription,

//          'haveOtherRegistration'=>$haveOtherRegistration,
//          'haveAllRegistrations'=>$haveAllRegistrations,
//          'filledOutSellingDetails'=>$filledOutSellingDetails
// ]);











//------------------------------------------DATABASE CONNECTION-----------------------------------//

         View::share('conn', $conn);


//------------------------------------------DYNAMIC HOST-----------------------------------//


        // View::share('publicFolder',$publicFolder);
        // View::share('privateFolder',$privateFolder);


//------------------------------------------ACCESSED USER-----------------------------------//

        View::share('user',$user);



//------------------------------------------SLUG-----------------------------------//

        View::share('slug',$slug);



//----------------------------------------TIME ZONE and CURRENT TIME----------------------------------//



View::share('currentTimeZone',$currentTimeZone);
View::share('currentTime',$currentTime);
View::share('currentTimeConverted',$currentTimeConverted);



// ------------------------------------------- CURRENT URL ------------------------------------------//

View::share('currentURL',$currentURL);
  
 


// //---------------------------------------- REGISTRANT RECORDS ---------------------------------//

$myRecords = $service->initialize_my_records();

View::share('loggedIn', $myRecords ['loggedIn']);
View::share('registrantId', $myRecords ['registrantId']);
View::share('registrantCode', $myRecords ['registrantCode']);
View::share('firstName',  $myRecords ['firstName']);
View::share('middleName',  $myRecords ['middleName']);
View::share('lastName',  $myRecords ['lastName']);
View::share('accountName',  $myRecords ['accountName']);
View::share('registrantDescription', $myRecords ['registrantDescription']);
View::share('type', $myRecords ['type']);
View::share('username', $myRecords ['username']);
View::share('emailAddress', $myRecords ['emailAddress']);
View::share('mobileNumber', $myRecords ['mobileNumber']);
View::share('birthdate', $myRecords ['birthdate']);
View::share('gender', $myRecords ['gender']);
View::share('civilStatus', $myRecords ['civilStatus']);

View::share('profilePictureLink',$myRecords ['profilePictureLink']);
View::share('coverPhotoLink',$myRecords ['coverPhotoLink']);

View::share('education', $myRecords ['education']);
View::share('school',$myRecords ['school']);
View::share('occupation', $myRecords ['occupation']);
View::share('street_subd_village', $myRecords ['street_subd_village']);
View::share('barangay', $myRecords ['barangay']);
View::share('city_municipality', $myRecords ['city_municipality']);
View::share('province_state', $myRecords ['province_state']);
View::share('region', $myRecords ['region']);
View::share('country', $myRecords ['country']);
View::share('zipcode', $myRecords ['zipcode']);
View::share('basicRegistration', $myRecords ['basicRegistration']);
View::share('teacherRegistration', $myRecords ['teacherRegistration']);
View::share('writerRegistration', $myRecords ['writerRegistration']);
View::share('editorRegistration', $myRecords ['editorRegistration']);
View::share('developerRegistration', $myRecords ['developerRegistration']);
View::share('researchesRegistration', $myRecords ['researchesRegistration']);
View::share('websiteManagerRegistration', $myRecords ['websiteManagerRegistration']);
View::share('websiteManagerSuperManagerRegistration', $myRecords ['websiteManagerSuperManagerRegistration']);
View::share('websiteManagerSubscriptionManagerRegistration', $myRecords ['websiteManagerSubscriptionManagerRegistration']);
View::share('websiteManagerRegistrationManagerRegistration', $myRecords ['websiteManagerRegistrationManagerRegistration']);
View::share('websiteManagerPromotionManagerRegistration', $myRecords ['websiteManagerPromotionManagerRegistration']);
View::share('websiteManagerMessageManagerRegistration', $myRecords ['websiteManagerMessageManagerRegistration']);

View::share('inSubscriptionSellerList', $myRecords ['inSubscriptionSellerList']);
View::share('inSubscriptionToolList', $myRecords ['inSubscriptionToolList']);
View::share('inSubscriptionFileList', $myRecords ['inSubscriptionFileList']);
View::share('inSubscriptionShelfList', $myRecords ['inSubscriptionShelfList']);

View::share('toolSubscribed', $myRecords ['toolSubscribed']);
View::share('fileSubscribed', $myRecords ['fileSubscribed']); 
View::share('sellerSubscribed', $myRecords ['sellerSubscribed']);  
View::share('shelfSubscribed', $myRecords ['shelfSubscribed']); 

View::share('pendingToolSubscription', $myRecords ['pendingToolSubscription']); 
View::share('pendingFileSubscription', $myRecords ['pendingFileSubscription']);
View::share('pendingSellerSubscription', $myRecords ['pendingSellerSubscription']);
View::share('pendingShelfSubscription', $myRecords ['pendingShelfSubscription']);

View::share('subscriptionRemainingDaysTool', $myRecords ['subscriptionRemainingDaysTool']);
View::share('subscriptionRemainingDaysFile', $myRecords ['subscriptionRemainingDaysFile']);
View::share('subscriptionRemainingDaysSeller', $myRecords ['subscriptionRemainingDaysSeller']);
View::share('subscriptionRemainingDaysShelf', $myRecords ['subscriptionRemainingDaysShelf']);
View::share('subscription', $myRecords ['subscription']);

View::share('haveOtherRegistration', $myRecords ['haveOtherRegistration']);
View::share('haveAllRegistrations', $myRecords ['haveAllRegistrations']);

View::share('filledOutSellingDetails', $myRecords ['filledOutSellingDetails']);

}




}