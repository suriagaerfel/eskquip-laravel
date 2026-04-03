<?php 
namespace App\Services;

use Illuminate\Database\Eloquent\Attributes\Initialize;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;



class MyInitialRecordsService
{
  
       public function initialize_my_records ($registrantCode)
    {

        $currentTime = now();;
        // $registrantCode= '2026000004272055'; 
        $loggedIn =  false;


        // -------------------------------- REGISTRANT RECORDS ----------------------------------//

        $registrantId = '';
         
        $firstName = '';
        $middleName = '';
        $lastName = '';
        $accountName = '';
        $registrantDescription = '';
        $type = '';

        $username = '';
        $emailAddress = '';
        $mobileNumber = '';

        $birthdate = '';
        $gender = '';
        $civilStatus = '';

        $profilePictureLink = '';
        $coverPhotoLink='';
        $education = '';
        $school = '';
        $occupation = '';

        $street_subd_village = '';
        $barangay = '';
        $city_municipality = '';
        $province_state = '';
        $region='';
        $country = '';
        $zipcode = '';

        $basicRegistration = '';
        $teacherRegistration = '';
        $writerRegistration = '';
        $editorRegistration = '';
        $websiteManagerRegistration = '';
        $developerRegistration = '';
        $researchesRegistration='';
        $websiteManagerRegistration='';

        $websiteManagerSuperManagerRegistration='';
        $websiteManagerSubscriptionManagerRegistration='';
        $websiteManagerRegistrationManagerRegistration='';
        $websiteManagerPromotionManagerRegistration='';
        $websiteManagerMessageManagerRegistration='';


        $inSubscriptionSellerList='';
        $inSubscriptionToolList='';
        $inSubscriptionFileList='';
        $inSubscriptionShelfList='';

        $toolSubscribed=false; 
        $fileSubscribed=false; 
        $sellerSubscribed=false;
        $shelfSubscribed=false; 

        $pendingToolSubscription=false;
        $pendingFileSubscription=false;
        $pendingSellerSubscription=false;
        $pendingShelfSubscription=false;

        $subscriptionRemainingDaysTool = '';
        $subscriptionRemainingDaysFile='';
        $subscriptionRemainingDaysSeller='';
        $subscriptionRemainingDaysShelf='';


        $haveOtherRegistration = false;
        $haveAllRegistrations=false;

    
        $filledOutSellingDetails="";

        $subscription='';
   

        if ($registrantCode) {

                $myRecords = DB::table('registrations')
                ->where('registrantCode',$registrantCode)
                ->first();


                //     return $myRecords;
                    if ($myRecords){
                        $loggedIn = true;
                        $registrantId = $myRecords->registrantId;
                        $firstName = $myRecords->registrantFirstName;
                        $middleName = $myRecords->registrantMiddleName;
                        $lastName = $myRecords->registrantLastName;
                        $type = $myRecords->registrantAccountType;
                        $accountName = $myRecords->registrantAccountName;
                        $registrantDescription = $myRecords ->registrantDescription;

                        $username = $myRecords->registrantUsername;
                        $emailAddress = $myRecords->registrantEmailAddress;
                        $mobileNumber = $myRecords->registrantMobileNumber;

                        $birthdate = $myRecords->registrantBirthdate;
                        $gender = $myRecords->registrantGender;
                        $civilStatus = $myRecords->registrantCivilStatus;

                        $education = $myRecords->registrantEducationalAttainment;
                        $school = $myRecords->registrantSchool;
                        $occupation = $myRecords->registrantOccupation;

                        $street_subd_village = $myRecords ->registrantAddressStreet;
                        $barangay = $myRecords ->registrantAddressBarangay;
                        $city_municipality = $myRecords ->registrantAddressCity;
                        $province_state = $myRecords ->registrantAddressProvince;
                        $region = $myRecords ->registrantAddressRegion;
                        $country = $myRecords ->registrantAddressCountry;
                        $zipcode = $myRecords ->registrantAddressZipCode;

                        $paymentChannel = $myRecords ->registrantPaymentChannel;
                        $bankAccountName = $myRecords ->registrantBankAccountName;
                        $bankAccountNumber = $myRecords ->registrantBankAccountNumber;
                        $reviewSchedules = $myRecords ->registrantReviewSchedules;



                        if ($paymentChannel && $bankAccountName && $bankAccountNumber && $reviewSchedules) {
                            $filledOutSellingDetails = "yes";
                        } 
                    

                        $profilePictureLink = $myRecords->registrantProfilePictureLink ? asset($myRecords->registrantProfilePictureLink) : asset("/images/user.svg");

                        $coverPhotoLink = $myRecords->registrantCoverPhotoLink ? asset($myRecords->registrantCoverPhotoLink) : asset("/images/cover-photo.jpeg");

                        $basicRegistration = $myRecords->registrantBasicAccount;
                        $teacherRegistration = $myRecords->registrantTeacherAccount;
                        $writerRegistration = $myRecords->registrantWriterAccount;
                        $editorRegistration = $myRecords->registrantEditorAccount;
                        $websiteManagerRegistration = '';
                        $developerRegistration = $myRecords->registrantDeveloperAccount;
                        $researchesRegistration = $myRecords->registrantResearchesAccount; 

                       

                         $websiteManagerRegistrations = DB::table('website_manager_accounts')
                        ->where('website_manager_accountRegistrant',$registrantId)
                        ->first();

                            if ($websiteManagerRegistrations){
                                    $websiteManagerSuperManagerRegistration = $websiteManagerRegistrations->website_manager_accountSuperManager;

                                    $websiteManagerSubscriptionManagerRegistration = $websiteManagerRegistrations->website_manager_accountSubscriptionManager;

                                    $websiteManagerRegistrationManagerRegistration = $websiteManagerRegistrations->website_manager_accountRegistrationManager;

                                    $websiteManagerPromotionManagerRegistration = $websiteManagerRegistrations->website_manager_accountPromotionManager;

                                    $websiteManagerMessageManagerRegistration = $websiteManagerRegistrations->website_manager_accountMessageManager;
                                
                                    if ($websiteManagerSuperManagerRegistration ||            $websiteManagerSubscriptionManagerRegistration || $websiteManagerRegistrationManagerRegistration || $websiteManagerPromotionManagerRegistration || $websiteManagerMessageManagerRegistration){
                                        $websiteManagerRegistration = 'Website Manager';
                                    }


                                    $websiteManagerRegistrationsComplete = [];

                                    if ($websiteManagerSuperManagerRegistration){
                                        array_push($websiteManagerRegistrationsComplete,$websiteManagerSuperManagerRegistration);
                                    }

                                    if ($websiteManagerSubscriptionManagerRegistration){
                                        array_push($websiteManagerRegistrationsComplete,$websiteManagerSubscriptionManagerRegistration);
                                    }

                                    if ($websiteManagerRegistrationManagerRegistration){
                                        array_push($websiteManagerRegistrationsComplete,$websiteManagerRegistrationManagerRegistration);
                                    }

                                    if ($websiteManagerPromotionManagerRegistration){
                                        array_push($websiteManagerRegistrationsComplete,$websiteManagerPromotionManagerRegistration);
                                    }

                                    if ($websiteManagerMessageManagerRegistration){
                                        array_push($websiteManagerRegistrationsComplete,$websiteManagerMessageManagerRegistration);
                                    }

                                    if ($websiteManagerRegistrationsComplete) {
                                        $websiteManagerRegistrationsComplete = implode(', ', $websiteManagerRegistrationsComplete);
                                    }


                                    
                        }

                        $registrations = [];
                    
                            if ($basicRegistration) {
                                array_push($registrations,$basicRegistration);
                            }

                            if ($teacherRegistration) {
                                array_push($registrations,$teacherRegistration);
                            }

                            if ($writerRegistration) {
                                array_push($registrations,$writerRegistration);
                            }
                            if ($editorRegistration) {
                                array_push($registrations,$editorRegistration);
                            }

                            if ($developerRegistration) {
                                array_push($registrations,$developerRegistration);
                            }

                            if ($websiteManagerRegistration) {
                                array_push($registrations,$websiteManagerRegistration);
                            }         

                        


                            


                            if ($registrations) {
                                $registrations = implode(' | ', $registrations);
                            }

                        if ($teacherRegistration || $writerRegistration || $editorRegistration || $websiteManagerRegistration ||  $developerRegistration || $researchesRegistration) {
                        $haveOtherRegistration = true;
                        }


                        if ($teacherRegistration && $writerRegistration && $editorRegistration && $websiteManagerRegistration &&  $developerRegistration) {
                        $haveAllRegistrations = true;
                        } 
                




                        //Check tool subscription                       
                        $inSubscriptionToolList = DB::table('registrant_subscriptions')
                        ->where('registrant_subscriptionUserId',$registrantId)
                        ->where('registrant_subscriptionType','Tools')
                        ->orderBy('registrant_subscriptionId','desc')
                        ->first();

                        if ($inSubscriptionToolList) {
                            $subscriptionStatusTool = $inSubscriptionToolList->registrant_subscriptionStatus;
                            $subscriptionExpiryTool = dcomplete_format($inSubscriptionToolList->registrant_subscriptionExpiry);


                            $subscriptionRemainingDaysTool = Carbon::parse($subscriptionExpiryTool)
                            ->diffInDays($currentTime, false);
                            
                            $inSubscriptionToolList="yes";

                        
                            if ($subscriptionStatusTool == 'Approved' || $subscriptionStatusTool == 'Kept' || $subscriptionStatusTool == 'Revoked') {
                            
                            if (Carbon::parse($subscriptionExpiryTool)->isFuture()) {
                                $toolSubscribed = true;
                            }

                            
                        
                            }

                            elseif ($subscriptionStatusTool == 'Pending') {
                            // $_SESSION ['pending-tool-subscription'] = "yes";
                            $pendingToolSubscription=true;

                        }     
                    
                        }

                        //Check file subscription
                        $inSubscriptionFileList = DB::table('registrant_subscriptions')
                        ->where('registrant_subscriptionUserId',$registrantId)
                        ->where('registrant_subscriptionType','Files')
                        ->orderBy('registrant_subscriptionId','desc')
                        ->first();


                        if ($inSubscriptionFileList) {
                            $subscriptionStatusFile = $inSubscriptionFileList->registrant_subscriptionStatus;
                            $subscriptionExpiryFile = dcomplete_format($inSubscriptionFileList->registrant_subscriptionExpiry);

                            $subscriptionRemainingDaysFile = Carbon::parse($subscriptionExpiryFile)
                            ->diffInDays($currentTime, false);

                            $inSubscriptionFileList="yes";

                        
                            if ($subscriptionStatusFile == 'Approved' || $subscriptionStatusFile == 'Kept' || $subscriptionStatusFile == 'Revoked') {
                               if (Carbon::parse($subscriptionExpiryFile)->isFuture()) {
                                    $toolSubscribed = true;
                                }
                            }

                            elseif ($subscriptionStatusFile == 'Pending') {
                            // $_SESSION ['pending-file-subscription'] = "yes";
                            $pendingFileSubscription=true;

                        }     
                    
                        }




                        //Check seller subscription
                        $inSubscriptionSellerList = DB::table('registrant_subscriptions')
                        ->where('registrant_subscriptionUserId',$registrantId)
                        ->where('registrant_subscriptionType','Seller')
                        ->orderBy('registrant_subscriptionId','desc')
                        ->first();


                        if ($inSubscriptionSellerList) {
                            $subscriptionStatusSeller = $inSubscriptionSellerList->registrant_subscriptionStatus;
                            $subscriptionExpirySeller = dcomplete_format($inSubscriptionSellerList->registrant_subscriptionExpiry);

                            $subscriptionRemainingDaysSeller = Carbon::parse($subscriptionExpirySeller)
                            ->diffInDays($currentTime, false);

                            $inSubscriptionSellerList="yes";

                        
                            if ($subscriptionStatusSeller == 'Approved' || $subscriptionStatusSeller == 'Kept' || $subscriptionStatusSeller == 'Revoked') {

                               if (Carbon::parse($subscriptionExpirySeller)->isFuture()) {
                                    $toolSubscribed = true;
                                }
                        
                            } elseif ($subscriptionStatusSeller == 'Pending') {
                            // $_SESSION ['pending-seller-subscription'] = "yes";
                            $pendingSellerSubscription=true;

                        }     
                    
                        }

                        //Check shelf subscription
                      $inSubscriptionShelfList = DB::table('registrant_subscriptions')
                        ->where('registrant_subscriptionUserId',$registrantId)
                        ->where('registrant_subscriptionType','Shelf')
                        ->orderBy('registrant_subscriptionId','desc')
                        ->first();


                        if ($inSubscriptionShelfList) {
                            $subscriptionStatusShelf = $inSubscriptionShelfList->registrant_subscriptionStatus;

                            $subscriptionExpiryShelf = dcomplete_format($inSubscriptionShelfList->registrant_subscriptionExpiry);

                            $subscriptionRemainingDaysShelf = Carbon::parse($subscriptionExpiryShelf)
                            ->diffInDays($currentTime, false);

                            $inSubscriptionShelfList="yes";

                        
                            if ($subscriptionStatusShelf == 'Approved' || $subscriptionStatusShelf == 'Kept' || $subscriptionStatusShelf == 'Revoked') {
                               if (Carbon::parse($subscriptionExpiryShelf)->isFuture()) {
                                    $toolSubscribed = true;
                                }
                            }

                            elseif ($subscriptionStatusShelf == 'Pending') {
                            // $_SESSION ['pending-shelf-subscription'] = "yes";
                            $pendingShelfSubscription=true;

                        }     
                    
                        }

                        if ($type=='Personal') {
                            if ($teacherRegistration) {
                                if ($inSubscriptionToolList && $inSubscriptionSellerList) {
                                $subscription = "disabled";
                                } 
                            }

                            if (!$teacherRegistration) {
                                if ($inSubscriptionToolList) {
                                $subscription = "disabled";
                                } 
                            }
                        }
                        
                        if ($type=='School') {
                            if ($inSubscriptionShelfList) {
                            $subscription = "disabled";
                            }
                        }
                        


                        //Check login status
                        
                        $lastLog = DB::table('registrant_activities')
                        ->where('registrant_activityUserId',$registrantId)
                        ->orderBy('registrant_activityId','desc')
                        ->first();

                        if ($lastLog) {
                        $lastLogContent =$lastLog->registrant_activityContent;

                        } 



            } 

                 
                    
        } 


     $initial_records= [
        'registrantCode' => $registrantCode,
        'loggedIn'=>$loggedIn,
        'registrantId' => $registrantId,
         'firstName'=>$firstName,
         'middleName'=>$middleName,
         'lastName'=>$lastName,
         'accountName'=>$accountName,
         'registrantDescription'=>$registrantDescription,
         'type'=>$type,
         'username'=>$username,
         'emailAddress'=>$emailAddress,
         'mobileNumber'=>$mobileNumber,
         'birthdate'=>$birthdate,
         'gender'=>$gender,
         'civilStatus'=>$civilStatus,
         'profilePictureLink'=>$profilePictureLink,
         'coverPhotoLink'=>$coverPhotoLink,
         'education'=>$education,
         'school'=>$school,
         'occupation'=>$occupation,
         'street_subd_village'=>$street_subd_village,
         'barangay'=>$barangay,
         'city_municipality'=>$city_municipality,
         'province_state'=>$province_state,
         'region'=>$region,
         'country'=>$country,
         'zipcode'=>$zipcode,
         'basicRegistration'=>$basicRegistration,
         'teacherRegistration'=>$teacherRegistration,
         'writerRegistration'=>$writerRegistration,
         'editorRegistration'=>$editorRegistration,
         'websiteManagerRegistration'=>$websiteManagerRegistration,
         'developerRegistration'=>$developerRegistration,
         'researchesRegistration'=>$researchesRegistration,
         'websiteManagerSuperManagerRegistration'=>$websiteManagerSuperManagerRegistration,
         'websiteManagerSubscriptionManagerRegistration'=>$websiteManagerSubscriptionManagerRegistration,
         'websiteManagerRegistrationManagerRegistration'=>$websiteManagerRegistrationManagerRegistration,
         'websiteManagerPromotionManagerRegistration'=>$websiteManagerPromotionManagerRegistration,
         'websiteManagerMessageManagerRegistration'=>$websiteManagerMessageManagerRegistration,
         'inSubscriptionSellerList'=>$inSubscriptionSellerList,
         'inSubscriptionToolList'=>$inSubscriptionToolList,
         'inSubscriptionFileList'=>$inSubscriptionFileList,
         'inSubscriptionShelfList'=>$inSubscriptionShelfList,
         'toolSubscribed'=>$toolSubscribed,
         'fileSubscribed'=>$fileSubscribed,
         'sellerSubscribed'=>$sellerSubscribed,
         'shelfSubscribed'=>$shelfSubscribed,
         'pendingToolSubscription'=>$pendingToolSubscription,
         'pendingFileSubscription'=>$pendingFileSubscription,
         'pendingSellerSubscription'=>$pendingSellerSubscription,
         'pendingShelfSubscription'=>$pendingShelfSubscription,

         'subscriptionRemainingDaysTool' => $subscriptionRemainingDaysTool,
        'subscriptionRemainingDaysFile'=>$subscriptionRemainingDaysFile,
        'subscriptionRemainingDaysSeller'=>$subscriptionRemainingDaysSeller,
        'subscriptionRemainingDaysShelf'=>$subscriptionRemainingDaysShelf,
        'subscription'=>$subscription,

         'haveOtherRegistration'=>$haveOtherRegistration,
         'haveAllRegistrations'=>$haveAllRegistrations,
         'filledOutSellingDetails'=>$filledOutSellingDetails
    ];

 return $initial_records;
   


   





    }
}



?>