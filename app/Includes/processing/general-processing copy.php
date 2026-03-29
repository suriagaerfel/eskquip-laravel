<?php

require '../../initialize.php';
require '../../database.php';


if (isset($_POST['get_general_records_submit'])) {

$query = htmlspecialchars($_POST['query']);
$queryIn = htmlspecialchars($_POST['query_in']);
$isWorkspace = htmlspecialchars($_POST['is_workspace']);
$fromPage = htmlspecialchars($_POST['page_name']);

$homeSearchedUser = htmlspecialchars($_POST['home_searched_user']);
$showShared = htmlspecialchars($_POST['show_shared']);

$category = htmlspecialchars($_POST['category']);
$tag = htmlspecialchars($_POST['tag']);
$date = htmlspecialchars($_POST['date']);
$owner = htmlspecialchars($_POST['owner']);




if ($queryIn=='teacher-files') {
    $table='teacher_files';
    $titleColumn='teacher_fileTitle';
    $slugColumn='teacher_fileSlug';
    $descriptionColumn='teacher_fileDescription';
    $descriptionLabel = 'Description';
    $categoryColumn = 'teacher_fileCategory';
    $tagsColumn = 'teacher_fileTags';
    $accessTypeColumn = 'teacher_fileAccessType';
    $imageColumn='teacher_fileImage';
    $defaultImage=$website.'/assets/images/default-file-image.jpg';
    $statusColumn = 'teacher_fileStatus';
    $statusValue = 'Published';
    $sortColumn = 'teacher_filePubDate';
    $sortColumnWorkspace = 'teacher_fileUpdateDate';
    $pageLink=$website.'/teacher-files/';
    $registrantIdColumn = 'teacher_fileTeacher';
    $workspace = '/workspace/teacher.php';
    $type='Teacher File';
    $idColumn='teacher_fileId';
    $workspaceType = 'file';
    $access = 'view';

    $ownerType = 'teacher';
}


if ($queryIn=='articles') {
    $table='writer_articles';
    $titleColumn='writer_articleTitle';
    $slugColumn='writer_articleSlug';
    $descriptionColumn='writer_articleContent';
    $descriptionLabel = 'Description';
    $categoryColumn = 'writer_articleCategory';
     $tagsColumn = 'writer_articleTags';
     $accessTypeColumn = 'writer_articleAccessType';
    $imageColumn='writer_articleImage';
    $defaultImage=$website.'/assets/images/default-article-image.jpg';
    $statusColumn = 'writer_articleStatus';
    $statusValue = 'Published';
    $sortColumn = 'writer_articlePubDate';
    $sortColumnWorkspace = 'writer_articleUpdateDate';
    $pageLink=$website.'/articles/';
    $registrantIdColumn = 'writer_articleWriter';
    $workspace = '/workspace/writer.php';
    $type='Article';
    $idColumn='writer_articleId';
    $workspaceType = 'article';

    if ($fromPage == 'Workspace - Editor') {
        $registrantIdColumn = 'writer_articleEditors';
        $workspace = '/workspace/editor.php';
        $statusValue = 'Waiting for Update';
    }

    $access = 'read';

    $ownerType = 'writer';
}



if ($queryIn=='researches') {
    $table='school_researches';
    $titleColumn='school_researchTitle';
    $slugColumn='school_researchSlug';
    $descriptionColumn='school_researchAbstract';
    $descriptionLabel = 'Abstract';
    $categoryColumn = 'school_researchCategory';
    $tagsColumn = 'school_researchTags';
    $accessTypeColumn = 'school_researchAccessType';
    $imageColumn='school_researchImage';
    $defaultImage=$website.'/assets/images/default-research-image.jpg';
    $statusColumn = 'school_researchStatus';
    $statusValue = 'Published';
    $sortColumn = 'school_researchLiveDate';
     $sortColumnWorkspace = 'school_researchUpdateDate';
    $pageLink=$website.'/researches/';
    $registrantIdColumn = 'school_researchSchool';
    $workspace = '/workspace/researches.php';
    $type='Research';
    $idColumn='school_researchId';
    $workspaceType = 'research';

    $access = 'view';

    $ownerType = 'school';
}

if ($queryIn=='tools') {
    $table='developer_tools';
    $titleColumn='developer_toolTitle';
    $descriptionColumn='developer_toolDescription';
    $descriptionLabel = 'Description';
    $categoryColumn = 'developer_toolCategory';
     $tagsColumn = 'developer_toolTags';
     $accessTypeColumn = 'developer_toolAccessType';
    $imageColumn='developer_toolImage';
    $defaultImage=$website.'/assets/images/default-tool-image.jpg';
    $slugColumn='developer_toolSlug';
    $statusColumn = 'developer_toolStatus';
    $statusValue = 'Published';
    $sortColumn = 'developer_toolPubDate';
    $sortColumnWorkspace = 'developer_toolUpdateDate';
    $pageLink=$website.'/tools/';
    $registrantIdColumn = 'developer_toolDeveloper';
    $workspace = '/workspace/developer.php';
    $type='Tool';
    $idColumn='developer_toolId';
    $workspaceType = 'tool';

    $access = 'use';

    $ownerType = 'developer';

}



if ($queryIn=='general-contents') {
    $table='contents';
    $foreignIdColumn = 'contentForeignId';
    $tableColumn = 'contentTable';
    $statusColumn = 'contentStatus';
    $statusValue = 'Published';
    $sortColumn = 'contentPubDate';
    $registrantIdColumn = 'contentRegistrantId';
}


if ($queryIn=='accounts') {
    $table='registrations';
    $titleColumn='registrantAccountName';
    $usernameColumn='registrantUsername';
    $descriptionColumn='registrantDescription';
    $imageColumn='registrantProfilePictureLink';
    $defaultImage=$website.'/assets/images/user.svg';
    $statusColumn = 'registrantVerificationStatus';
    $statusValue = 'Verified';
    $sortColumn = 'registrantCreatedAt';
    $pageLink=$website.'/';
    $searchedTable="";
    $categoryColumn = 'registrantAccountType';
    $type = 'Account';
    $idColumn='registrantId';
    $registrantIdColumn=$idColumn;

    $descriptionLabel = 'Description';
    $access = 'visit';
}


   
   if (!$isWorkspace) {
    if (!$query) {


        $sqlRecords = "SELECT * FROM $table WHERE $statusColumn='$statusValue' ORDER BY $sortColumn DESC";
        $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
   
       
        if ($homeSearchedUser) {
            $sqlRecords = "SELECT * FROM $table WHERE $registrantIdColumn= $homeSearchedUser AND $statusColumn='$statusValue' ORDER BY $sortColumn DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);

            if ($showShared){
                 $sqlRecords = "SELECT * FROM $table WHERE contentSharedWith LIKE '%$homeSearchedUser%' AND $statusColumn='$statusValue' ORDER BY $sortColumn DESC";
                $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
            }
        }

        if ($category) {
            $sqlRecords = "SELECT * FROM $table WHERE $statusColumn='$statusValue' AND $categoryColumn = '$category' ORDER BY $sortColumn DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        }


        if ($tag) {
            $sqlRecords = "SELECT * FROM $table WHERE $statusColumn='$statusValue' AND $tagsColumn LIKE  '%$tag%'  ORDER BY $sortColumn DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        }


        if ($date) {
            $sqlRecords = "SELECT * FROM $table WHERE $statusColumn='$statusValue' AND $sortColumn LIKE '%$date%' ORDER BY $sortColumn DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        }


         if ($owner) {
            $sqlRecords = "SELECT * FROM $table WHERE $statusColumn='$statusValue' AND $registrantIdColumn = '$owner' ORDER BY $sortColumn DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        }



    }
    

    if ($query) {

        if ($fromPage != 'Home') {
            $sqlRecords = "SELECT * FROM $table WHERE $titleColumn LIKE '%$query%' AND $statusColumn='$statusValue' OR $descriptionColumn LIKE '%$query%' AND $statusColumn='$statusValue' ORDER BY $sortColumn DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        }

        // if ($fromPage == 'Home') {
        //     $sqlRecords = "SELECT * FROM $table WHERE $registrantIdColumn=$query AND $statusColumn='$statusValue' ORDER BY $sortColumn DESC";
        //     $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        // }
        
    }

    

   

   }

    if ($isWorkspace) {
        $sqlRecords = "SELECT * FROM $table WHERE $registrantIdColumn='$registrantId' ORDER BY $sortColumnWorkspace DESC";
        $sqlRecordsResult = mysqli_query($conn,$sqlRecords);


        if ($query) {
        $sqlRecords = "SELECT * FROM $table WHERE $registrantIdColumn='$registrantId' AND $titleColumn LIKE '%$query%' ORDER BY $sortColumnWorkspace DESC";
        $sqlRecordsResult = mysqli_query($conn,$sqlRecords);
        }

        if ($fromPage == 'Workspace - Editor') {

            $sqlRecords = "SELECT * FROM $table WHERE $statusColumn='$statusValue' ORDER BY $sortColumnWorkspace DESC";
            $sqlRecordsResult = mysqli_query($conn,$sqlRecords);

        }
    }
    
 


   if ($sqlRecordsResult->num_rows>0) { 

      while($result = $sqlRecordsResult->fetch_assoc()){ 

      if (!$isWorkspace) {

      if ($queryIn != 'general-contents') {
        $resultId = $result [$idColumn];
         $resultTitle = $result [$titleColumn];
         $resultImage = $result [$imageColumn] ? $privateFolder.$result[$imageColumn]: $defaultImage;
         $resultCategory = $result [$categoryColumn];
         $resultRegistrantId = $result [$registrantIdColumn];
         

       
        $resultDescription = limit_words($result [$descriptionColumn], 50);
        $resultPubDate = dcomplete_format($result [$sortColumn]);

        $href = '';


        $sqlRegistration = "SELECT * FROM registrations WHERE registrantId = $resultRegistrantId";
        $sqlRegistrationResult = mysqli_query($conn,$sqlRegistration);
        $registration = $sqlRegistrationResult->fetch_assoc();

        if ($registration){
            $resultRegistrantAccountName = $registration ['registrantAccountName'];
            $resultRegistrantUsername = $registration ['registrantUsername'];
        }
       

         if ($queryIn !='accounts') {
            $resultViewMode = $result [$accessTypeColumn];
             $resultTags = $result [$tagsColumn];
            $resultSlug = $result [$slugColumn];
            $href=$pageLink.$access.'/'.$resultSlug;

             if ($queryIn == 'tools') {
                $href = $publicFolder.str_replace('/public','',$resultSlug);
            }
         }

          if ($queryIn =='accounts') {
            $resultUsername = $result [$usernameColumn];
            $href=$pageLink.$resultUsername;

            $resultViewMode = 'Public';
         }

        

      }


      if ($queryIn == 'general-contents') {
        $resultTable = $result [$tableColumn];
        $resultForeignId = $result [$foreignIdColumn];
        
        if ($resultTable == 'teacher_files') {
            $idColumn = 'teacher_fileId';
            $titleColumn = 'teacher_fileTitle';
            $slugColumn = 'teacher_fileSlug';
            $categoryColumn = 'teacher_fileCategory';
            $tagsColumn = 'teacher_fileTags';
            $accessTypeColumn = 'teacher_fileAccessType';
            $pubDateColumn = 'teacher_filePubDate';
            $descriptionColumn = 'teacher_fileDescription';
            $descriptionLabel = 'Description';
            $registrantIdColumn= 'teacher_fileTeacher';
            $imageColumn = 'teacher_fileImage';
            $defaultImage=$website.'/assets/images/default-file-image.jpg';
            $pageLink=$website.'/teacher-files/';
            $type = 'Teacher File';
           

            $access = 'view';

            $ownerType = 'teacher';
            
        }

        if ($resultTable == 'writer_articles') {
            $idColumn = 'writer_articleId';
            $titleColumn = 'writer_articleTitle';
            $slugColumn = 'writer_articleSlug';
            $categoryColumn = 'writer_articleCategory';
            $tagsColumn = 'writer_articleTags';
            $accessTypeColumn = 'writer_articleAccessType';
            $pubDateColumn = 'writer_articlePubDate';
            $descriptionColumn = 'writer_articleDescription';
            $descriptionLabel = 'Description';
            $registrantIdColumn= 'writer_articleWriter';
            $imageColumn = 'writer_articleImage';
            $defaultImage=$website.'/assets/images/default-article-image.jpg';
            $pageLink=$website.'/articles/';
            $type = 'Article';
          

            $access = 'read';

            $ownerType = 'writer';
        }

        if ($resultTable == 'school_researches') {
            $idColumn = 'school_researchId';
            $titleColumn = 'school_researchTitle';
            $slugColumn = 'school_researchSlug';
            $categoryColumn = 'school_researchCategory';
            $tagsColumn = 'school_researchTags';
            $accessTypeColumn = 'school_researchAccessType';
            $pubDateColumn = 'school_researchLiveDate';
            $descriptionColumn = 'school_researchAbstract';
            $descriptionLabel = 'Abstract';
            $registrantIdColumn= 'school_researchSchool';
            $imageColumn = 'school_researchImage';
            $defaultImage=$website.'/assets/images/research.jpg';
            $pageLink=$website.'/researches/';
            $type = 'Research';
      

            $access = 'view';
            $ownerType = 'school';
        }

        if ($resultTable == 'developer_tools') {
            $idColumn = 'developer_toolId';
            $titleColumn = 'developer_toolTitle';
             $slugColumn='developer_toolSlug';
             $categoryColumn = 'developer_toolCategory';
            $tagsColumn = 'developer_toolTags';
            $accessTypeColumn = 'developer_toolAccessType';
            $pubDateColumn = 'developer_toolPubDate';
            $descriptionColumn = 'developer_toolDescription';
            $descriptionLabel = 'Description';
            $registrantIdColumn= 'developer_toolDeveloper';
            $imageColumn = 'developer_toolImage';
           $defaultImage=$website.'/assets/images/default-tool-image.jpg';
            $pageLink=$website.'/tools/';
            $type = 'Tool';
            $categoryColumn = 'developer_toolCategory';

            $access = 'use';
            $ownerType = 'developer';
        }

        $sqlGeneralRecords = "SELECT * FROM $resultTable WHERE $idColumn = $resultForeignId";
        $sqlGeneralRecordsResult = mysqli_query($conn,$sqlGeneralRecords);
        $generalResult = $sqlGeneralRecordsResult->fetch_assoc();
         $resultId = $generalResult [$idColumn];
        $resultTitle = $generalResult [$titleColumn];
        $resultImage = $generalResult [$imageColumn] ? $privateFolder.$generalResult[$imageColumn]: $defaultImage;
        
       $resultDescription = limit_words($generalResult [$descriptionColumn], 50);
        $resultCategory = $generalResult [$categoryColumn];
        $resultSlug = $generalResult [$slugColumn];

        $resultRegistrantId = $generalResult [$registrantIdColumn];

        $resultViewMode = $generalResult [$accessTypeColumn];
        $resultTags = $generalResult [$tagsColumn];
        $resultPubDate = dcomplete_format($generalResult [$pubDateColumn]);

        $href=$pageLink.$access.'/'.$resultSlug;   

        if ($resultTable=='developer_tools') {
            $href = $publicFolder.str_replace('/public','',$resultSlug);
        }

        $sqlRegistration = "SELECT * FROM registrations WHERE registrantId = $resultRegistrantId";
        $sqlRegistrationResult = mysqli_query($conn,$sqlRegistration);
        $registration = $sqlRegistrationResult->fetch_assoc();

        if ($registration){
            $resultRegistrantAccountName = $registration ['registrantAccountName'];
            $resultRegistrantUsername = $registration ['registrantUsername'];
        }

      }
}





 if ($isWorkspace) {

      if ($queryIn != 'general-contents') {
         $resultTitle = $result [$titleColumn];
         $resultImage = $result [$imageColumn] ? $privateFolder.$result[$imageColumn]: $defaultImage;
         $resultId = $result [$idColumn];
         $resultSlug = $result [$slugColumn];
         $resultStatus = $result [$statusColumn];
         $resultCategory = $result [$categoryColumn];

      }


     
}


$accessLabel = ucwords($access);
$lowerType = str_replace(' ','-',strtolower($type));


if (!$isWorkspace) {
    $hrefPubDate = date('Y-m',strtotime($resultPubDate));

    if ($resultCategory != 'Administrative') {

    echo "
       
          <div style='display:flex; gap:10px;'>

            <div>  
                <img src=$resultImage style='width:200px;'>
            </div>

           <div>

                <a><h2 id='result-title'>$resultTitle</h2></a>                
                <div>";
                    

                if($queryIn == 'accounts') {
                echo "
                    <a class='".'link-tag-button contents-list-label'."'>$type</a>
                   
                    <a class='".'link-tag-button contents-list-label'."'>$resultCategory</a>
                  
                    <span class='".'link-tag-button contents-list-label'."'>$resultViewMode</span>
                ";
                }

                if($queryIn != 'accounts'){
                echo "
                    <a href='$pageLink'class='".'link-tag-button contents-list-label'."'>$type</a>
                   
                    <a href='".$pageLink."category/".$resultCategory."' class='".'link-tag-button contents-list-label'."'>$resultCategory</a>

                    <a href='".$pageLink.$ownerType."/".$resultRegistrantUsername."'class='".'link-tag-button contents-list-label'."'>$resultRegistrantAccountName</a>

                    
                    <a href='".$pageLink."date/".$hrefPubDate."'class='".'link-tag-button contents-list-label'."'>$resultPubDate</a>
                  
                    <span class='".'link-tag-button contents-list-label'."'>$resultViewMode</span>
                ";
                }



            echo "
          
                </div>
                ";






            if ($queryIn != 'accounts'){


                echo "
                <br>
                <div>
                    <small>Tag (s): </small>";


                if ($resultTags) {
                    $resultTags = explode(', ',$resultTags);
                    foreach ($resultTags as $resultTag){
                    echo "
                    
                        <a class='".'link-tag-button contents-list-label'."' href='".$pageLink.'tag/'.urldecode($resultTag)."'>$resultTag</a>
                    
                        ";  
                    
                    }

                } else {
                    echo '<small>None</small>';
                }
               


                echo "
                </div>";





                

            }

            




            echo "
                <br>
                <div>
                ";


            if ($resultDescription) {
                 echo "
                    <small style='font-weight:bold;'>$descriptionLabel:</small>
                ";
            }
           


            echo "
                    <small>$resultDescription</small>





                </div>
                <br>
                <div>
                    <a class='link-tag-button' href='".$href."' target='_blank'>$accessLabel</a>";


                if($resultViewMode == 'Purchased') {
                    
                

                if (!$registrantId){
                    echo "
                    
                    <a class='".'link-tag-button purchase'."' id='".'purchase-'.$lowerType.'-'.$resultId."'>Purchase</a>
                    
                    "; 
                }

                if ($registrantId){

                    if ($registrantId != $resultRegistrantId) {

                    $sqlPurchased = "SELECT * FROM content_purchase WHERE content_purchaseType = '$type' AND content_purchaseContentId = '$resultId'  AND content_purchaseRegistrantId = '$registrantId'";
                    $sqlPurchasedResult = mysqli_query($conn,$sqlPurchased);
                    $purchased = $sqlPurchasedResult->fetch_assoc();

                    if($purchased){
                        $purchasedStatus = $purchased ['content_purchaseStatus'];
                    }

                        if(!$purchased) {
                        echo "
                        
                        <a class='".'link-tag-button purchase'."' id='".'purchase-'.$lowerType.'-'.$resultId."'>Purchase</a>
                        
                        "; 
                        }

                        if($purchased) {
                            echo "
                            <a class='".'link-tag-button purchase active'."' id='".'purchase-'.$lowerType.'-'.$resultId."'>$purchasedStatus</a>
 
                            ";
                        }
                    }
                    
                }
                      
                    
                }


echo "
                </div>
          
            </div>

            
         </div>

         <hr>";
         
    }
         

}





if ($isWorkspace) {

    
    $editHref = $website.$workspace.'?edit=yes&'.$workspaceType.'='.$resultId;
    $editId = 'edit-'.$workspaceType.'-'.$resultId;
    $viewHref = $pageLink.$access.'/'.$resultSlug;
    
    if ($queryIn == 'tools') {
        $viewHref = $publicFolder.str_replace('/public','',$resultSlug);
    }
    

    echo "
        
        <div style='display:flex; gap:10px;'>

            <div>
                <img src=$resultImage style='width:100px;'>
            </div>

           <div style='display:flex; flex-direction:column; gap:10px;'>
                <div>
                    <strong>$resultTitle</strong>
                </div>
            
                <div>
                    <small class='".'link-tag-button contents-list-label'."'>$resultCategory</small>
              
                    <small class='".'link-tag-button contents-list-label'."'>$resultStatus</small>
                </div>
            
            
                <div id='sidebar-actions'>
                    <a class='link-tag-button' id='$editId'>Edit</a>
                    <a class='link-tag-button' href='".$viewHref."' target='_blank'>$accessLabel</a>
                </div>
            </div>


             
            
           
          
           
            

            
         </div>

         <hr>
         
         
         ";



}

        

         

        
        
            
   } 
 

   }  else {
    if ($query) {
        echo '<small>No result</small>';
    }
   }
}



if (isset($_POST['get_site_manager_records_submit'])){
    $recordCategory = htmlspecialchars($_POST['record_category']);
    $recordSubCategory = htmlspecialchars($_POST['record_sub_category']);
    $recordStatus = htmlspecialchars($_POST['record_status']);
    $recordDate = $_POST['record_date'] ? date('Y-m',strtotime(htmlspecialchars($_POST['record_date']))) : '';
    $recordSearch = htmlspecialchars($_POST['record_search']);

    if ($recordCategory=='General Registration'){
        $table = 'registrations';
        $statusColumn = 'registrantStatus';

        if ($recordStatus){
            if ($recordStatus == 'Verified' || $recordStatus == 'Unverified') {
              $statusColumn = 'registrantVerificationStatus';  
            }
        }
        $dateColumn = 'registrantCreatedAt';
        $subColumn = 'registrantAccountType';
        $searchColumn = 'registrantAccountName';
        $idColumn = 'registrantId';
        $registrantIdColumn = $idColumn;

        $recordType = 'general-registration';
    }

    if ($recordCategory=='Other Registration'){
        $table = 'other_registrations';
        $statusColumn = 'otherStatus';
        $dateColumn = 'otherTimestamp';
        $subColumn = 'otherType';

        $idColumn = 'otherId';
        $registrantIdColumn = 'otherUserId';
        $recordType = 'other-registration';
        $searchColumn = 'otherRegistrantAccountName';
    }

    if ($recordCategory=='Subscription'){
        $table = 'registrant_subscriptions';
        $statusColumn = 'registrant_subscriptionStatus';
        $dateColumn = 'registrant_subscriptionTimestamp';
        $subColumn = 'registrant_subscriptionType';
        $idColumn = 'registrant_subscriptionId';
        $registrantIdColumn = 'registrant_subscriptionUserId';

        $recordType = 'subscription';
        $searchColumn = 'registrant_subscriptionRegistrantAccountName';
    }

    if ($recordCategory=='Promotion'){
        $table = 'promotions';
        $statusColumn = 'promotionStatus';
        $dateColumn = 'promotionTimestamp';
        $subColumn = 'promotionType';
        $idColumn = 'promotionId';

        $recordType = 'promotion';
        $searchColumn = 'promotionNameCompany';
    }


     if ($recordCategory=='Messages'){
        $table = 'admin_messages';
        $statusColumn = 'admin_messageStatus';
        $dateColumn = 'admin_messageTimestamp';
        $subColumn = 'admin_messageType';
        $idColumn = 'admin_messageId';
        $registrantIdColumn = 'admin_messageRegistrantId';
        $recordType = 'message';
        $searchColumn = 'admin_messageRegistrantAccountName';
    }



   
    
   
    if (!$recordSubCategory && !$recordStatus && !$recordDate && !$recordSearch) {
        $sqlCreteria = ' FROM '.$table;
    }
  

    if ($recordSubCategory || $recordStatus || $recordDate || $recordSearch) {

        

        $sqlCreteria = ' FROM '.$table.' WHERE ';
        $additionalCreteria = [];


        if ($recordSubCategory) {
            array_push($additionalCreteria, "$subColumn = '$recordSubCategory'");
        }

        if ($recordStatus) {
            array_push($additionalCreteria, "$statusColumn = '$recordStatus'");
        }

        if ($recordDate) {
            array_push($additionalCreteria, "$dateColumn LIKE '%$recordDate%'");
        }

        if ($recordSearch) {
            array_push($additionalCreteria, "$searchColumn LIKE '%$recordSearch%'");
        }

        $sqlCreteria .= implode(' AND ', $additionalCreteria);

         
    }



  



    // $sqlCount = 'SELECT *'. $sqlCreteria;
    $sqlRecords = 'SELECT *'. $sqlCreteria.' ORDER BY '.$dateColumn.' DESC';



    $sqlRecordsResult= mysqli_query($conn,$sqlRecords);
    $recordsCount = $sqlRecordsResult->num_rows;

     echo "
        <div>
            <p>$recordsCount results</p>
            <p> $recordDate</p>
        </div>";
    
        if ($recordCategory == 'Promotion') {
        echo 
        "<div>
            <a id='new-promotion' class='link-tag-button'>Add Promotion</a>
        </div>";
        }
        
     echo "     
        <hr>
    ";

    if ($sqlRecordsResult->num_rows>0){
       
        echo "
        <div id='sm-records-list'>
        ";
        while($listRecords = $sqlRecordsResult->fetch_assoc()){
            $listRecordId = $listRecords  [$idColumn];
            
            $listRecordSubCategory = $listRecords  [$subColumn];
            $listRecordStatus = $listRecords  [$statusColumn];
            $listRecordDate = dcomplete_format($listRecords  [$dateColumn]);

            if ($recordCategory != 'Promotion'){
                $listRecordRegistrantId = $listRecords  [$registrantIdColumn];

                $sqlListRegistrant = "SELECT * FROM registrations WHERE registrantId = '$listRecordRegistrantId'";
                $sqlListRegistrantResult = mysqli_query($conn,$sqlListRegistrant);
                $listRegistrant = $sqlListRegistrantResult->fetch_assoc();
                
                if($listRegistrant){
                    $listRecordRegistrant =  $listRegistrant ['registrantAccountName'];
                }

            }


            if ($recordCategory == 'Promotion'){
                $listRecordRegistrant = $listRecords ['promotionNameCompany'];
            }


            if ($recordCategory == 'Subscription') {
                $listRecordDuration = $listRecords['registrant_subscriptionDuration'];
                $listRecordTotal = $listRecords['registrant_subscriptionTotal'];
                $listRecordPaymentOption = $listRecords['registrant_subscriptionPaymentOption'];
                $listRecordAccountNumber = $listRecords['registrant_subscriptionSenderAccountNumber'];
                $listRecordReferenceNumber = $listRecords['registrant_subscriptionRefNumber'];
                $listRecordProofOfPayment = $privateFolder.$listRecords['registrant_subscriptionProofOfPayment'];
                $listRecordApprovalDate = $listRecords['registrant_subscriptionDate'] ? dcomplete_format($listRecords['registrant_subscriptionDate'])  : '-';
                $listRecordExpiryDate = $listRecords['registrant_subscriptionExpiry'] ? dcomplete_format($listRecords['registrant_subscriptionExpiry']) : '-';
            
            }



            echo "
                <div id='".'details-for-record-'.$listRecordId."' style='margin-bottom:10px;
                height:fit-content; display:inline-block; gap:10px;'>
                    <input id='record-category' value = '".$recordCategory."' hidden>
                    <h5>$listRecordRegistrant</h5>
                    <div style='display:inline-block;gap:15px;' id='sm-record-main-details'>
                    ";

            echo "  <div style='display:flex; gap: 30px;'>
                            <div>
                                <div>
                                    <strong>Type:</strong>
                                    <span >$listRecordSubCategory</span>
                                </div>

                                <div>
                                    <strong>Status:</strong>
                                    <span >$listRecordStatus</span>
                                </div>

                                <div>
                                    <strong>Date/Time:</strong>
                                    <span >$listRecordDate</span>
                                </div>
                            </div>
                ";


                    if ($recordCategory == 'Subscription') {
                        echo "
                            <div style='display:flex;gap: 30px;'>
                                <div>
                                    <div>
                                        <strong>Duration:</strong>
                                        <span >$listRecordDuration</span>
                                    </div>

                                    <div>
                                        <strong>Total:</strong>
                                        <span >$listRecordTotal</span>
                                    </div>

                                    <div>
                                        <strong>Payment Option:</strong>
                                        <span >$listRecordPaymentOption</span>
                                    </div>

                                    <div>
                                        <strong>Account Number:</strong>
                                        <span >$listRecordAccountNumber</span>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <strong>Reference Number:</strong>
                                        <span >$listRecordReferenceNumber</span>
                                    </div>

                                    <div>
                                        <strong>Proof of Payment:</strong>
                                        <a href='".$listRecordProofOfPayment."' target='_blank'>View</a>
                                    </div>

                                    <div>
                                        <strong>Approved:</strong>
                                        <span >$listRecordApprovalDate</span>
                                    </div>

                                    <div>
                                        <strong>Expired:</strong>
                                        <span>$listRecordExpiryDate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";

                }



            echo    "
                    </div>";

                
                if ($recordCategory == 'General Registration') {
                    $listRecordAddressStreet= $listRecords ['registrantAddressStreet'];
                    $listRecordAddressBarangay= $listRecords ['registrantAddressBarangay'];
                    $listRecordAddressCity= $listRecords ['registrantAddressCity'];
                    $listRecordAddressProvince= $listRecords ['registrantAddressProvince'];
                    $listRecordAddressRegion= $listRecords ['registrantAddressRegion'];
                    $listRecordAddressCountry= $listRecords ['registrantAddressCountry'];
                    $listRecordAddressZipCode= $listRecords ['registrantAddressZipCode'];

                    $listRecordCompleteAddress = [];
                    
                    if ($listRecordAddressStreet){
                        array_push( $listRecordCompleteAddress,$listRecordAddressStreet);
                    }

                    if ($listRecordAddressBarangay){
                        array_push( $listRecordCompleteAddress,$listRecordAddressBarangay);
                    }

                    if ($listRecordAddressCity){
                        array_push( $listRecordCompleteAddress,$listRecordAddressCity);
                    }

                     if ($listRecordAddressProvince){
                        array_push( $listRecordCompleteAddress,$listRecordAddressProvince);
                    }

                     if ($listRecordAddressRegion){
                        array_push( $listRecordCompleteAddress,$listRecordAddressRegion);
                    }

                     if ($listRecordAddressCountry){
                        array_push( $listRecordCompleteAddress,$listRecordAddressCountry);
                    }

                     if ($listRecordAddressZipCode){
                        array_push( $listRecordCompleteAddress,$listRecordAddressZipCode);
                    }


                    if ($listRecordCompleteAddress) {
                        $listRecordCompleteAddressConverted = implode(',',$listRecordCompleteAddress);
                    } else {
                         $listRecordCompleteAddressConverted = 'No address';
                    }
                  
                  
                  
            
                    echo "
                    <div>
                        <strong>Complete Address:</strong>
                        <span>$listRecordCompleteAddressConverted</span>
                       
                    </div>
                          
                    ";
                }



                if ($recordCategory == 'Other Registration') {
                    $listRecordSample = $listRecords['otherSample'];
                    $listRecordLicenseCertification = $privateFolder.$listRecords['otherLicenseCertification'];
                    $listRecordAgreement = $privateFolder.$listRecords['otherAgreement'];
               
                    echo "
                    <br>
                    <br>
                    <div>";

                    if ($listRecordSubCategory == 'Teacher') {
                        echo "
                             <a class='link-tag-button' href='".$listRecordSample."' target='_blank'>Sample(s)</a>
                        ";
                    }

                    if ($listRecordSubCategory== 'Writer' || $listRecordSubCategory == 'Editor' || $listRecordSubCategory == 'Developer') {
                        echo "
                             <a class='link-tag-button' href='".$listRecordLicenseCertification."' target='_blank'>License or Certification</a>
                        ";
                    }
    
                    
                    echo "
                    <a class='link-tag-button' href='".$listRecordAgreement."' target='_blank'>Agreement</a>
                    </div>
                          
                    ";
                }

              


                if ($recordCategory == 'Promotion') {
                     $listRecordTitle = $listRecords ['promotionTitle'];
                    $listRecordTopics = $listRecords ['promotionTopics'];
                    $listRecordDescription = $listRecords ['promotionDescription'];
                    $listRecordDuration = $listRecords ['promotionDuration'];
                    $listRecordAmount = $listRecords ['promotionAmount'];
                    $listRecordLink = $listRecords ['promotionLink'];
                    $listRecordImageLink = $listRecords ['promotionImage'];
                    $listRecordAgreementLink = $listRecords ['promotionAgreement'];
                    echo "
                    <div>
                        <input id='".'update-promotion-name-company-'.$listRecordId."' value='".$listRecordRegistrant."' hidden>
                        <input id='".'update-promotion-title-'.$listRecordId."' value='".$listRecordTitle."' hidden>
                         <input id='".'update-promotion-type-'.$listRecordId."' value='".$listRecordSubCategory."' hidden>
                        <input id='".'update-promotion-topics-'.$listRecordId."' value='".$listRecordTopics."' hidden>
                        <input id='".'update-promotion-description-'.$listRecordId."' value='".$listRecordDescription."' hidden>
                         <input id='".'update-promotion-duration-'.$listRecordId."' value='".$listRecordDuration."' hidden>
                          <input id='".'update-promotion-amount-'.$listRecordId."' value='".$listRecordAmount."' hidden>
                          <input id='".'update-promotion-link-'.$listRecordId."' value='".$listRecordLink."'hidden>
                          <input id='".'update-promotion-image-link-'.$listRecordId."' value='".$listRecordImageLink."' hidden>
                          <input id='".'update-promotion-agreement-link-'.$listRecordId."' value='".$listRecordAgreementLink."' hidden>
                    </div>
                          
                    ";
                }




                    
            echo "
                    <div id='sm-record-actions' style='margin-top:10px;'>

                    ";


                       if ($recordCategory != 'Promotion') {

                      
                        if ($listRecordStatus =='Pending') {
                    
                        echo "
                            <a class='link-tag-button' id='".'approve-'.$recordType.'-'.$listRecordSubCategory.'-'.$listRecordId."'>Approve</a>
                            
                            <a class='link-tag-button' id='".'reject-'.$recordType.'-'.$listRecordSubCategory.'-'.$listRecordId."'>Reject</a>
                        ";
                        }


                         if ($listRecordStatus =='Rejected') {
                            echo "
                                <a class='link-tag-button' id='".'approve-'.$recordType.'-'.$listRecordSubCategory.'-'.$listRecordId."'>Approve</a>
                            ";
                        }

                        
                        if ($listRecordStatus =='Approved' || $listRecordStatus =='Kept' || $listRecordStatus =='No Ban') {
                        echo "
                            <a class='link-tag-button' id='".'revoke-'.$recordType.'-'.$listRecordSubCategory.'-'.$listRecordId."'>Revoke</a>
                        ";
                        }


                         if ($listRecordStatus =='Revoked') {
                        echo "
                            <a class='link-tag-button' id='".'keep-'.$recordType.'-'.$listRecordSubCategory.'-'.$listRecordId."'>Keep</a>
                        ";
                        }
                        

                        }


                        if ($recordCategory == 'Promotion') {
                        echo "
                        <a class='link-tag-button' id='".'show-'.$recordType.'-'.$listRecordId."'>Show</a>
                        ";

                        if ($listRecordStatus !='Published') {
                        echo "
                        <a class='link-tag-button' id='".'status-to-publish-'.$recordType.'-'.$listRecordId."'>Publish</a>";
                        }

                        if ($listRecordStatus =='Published') {
                        echo "
                       <a class='link-tag-button' id='".'status-to-unpublish-'.$recordType.'-'.$listRecordId."'>Unpublish</a>";
                        }


                          
                                                

                        }
                       




                echo "
                        <a class='link-tag-button' id='".'delete-'.$recordType.'-'.$listRecordId."'>Delete</a>
                    </div>
                    
                    
            
                </div>
                <hr>
                
                
                ";



        }

        echo "
        </div>
        ";


    } 

    
   









}



if (isset($_POST['promotion_submit'])) {

$promotionId = htmlspecialchars($_POST['promotion_id']);

$promotionNameCompany = htmlspecialchars($_POST['promotion_name_company']);
$promotionTitle = htmlspecialchars($_POST['promotion_title']);
$promotionType = htmlspecialchars($_POST['promotion_type']);
$promotionTopics = htmlspecialchars($_POST['promotion_topics']);
$promotionDescription = htmlspecialchars($_POST['promotion_description']);
$promotionLink = htmlspecialchars($_POST['promotion_link']);
$promotionDuration = htmlspecialchars($_POST['promotion_duration']);
$promotionAmount = htmlspecialchars($_POST['promotion_amount']);

$promotionImageLink = htmlspecialchars($_POST['promotion_image_link']);
$promotionAgreementLink = htmlspecialchars($_POST['promotion_agreement_link']);

$promotionImage = '';
$promotionImageFileName= '';
$promotionImageFileNameExt = '';
$promotionImageFileNameActualExt = '';

if (isset($_FILES['promotion_image'])) {
  $promotionImage = $_FILES ['promotion_image'];
  $promotionImageFileName= $promotionImage ['name'];
  $promotionImageFileNameExt = explode ('.',$promotionImageFileName);
  $promotionImageFileNameActualExt = strtolower(end($promotionImageFileNameExt));
}

$promotionAgreement = '';
$promotionAgreementFileName= '';
$promotionAgreementFileNameExt = '';
$promotionAgreementFileNameActualExt = '';

if (isset($_FILES['promotion_agreement'])) {
  $promotionAgreement = $_FILES ['promotion_agreement'];
  $promotionAgreementFileName= $promotionAgreement ['name'];
  $promotionAgreementFileNameExt = explode ('.',$promotionAgreementFileName);
  $promotionAgreementFileNameActualExt = strtolower(end($promotionAgreementFileNameExt));
}

$allowedExtPromotionImage = ['jpeg','jpg'];
$allowedExtPromotionAgreement = ['pdf'];

$promotionErrors = [];
$responses = [];


if (!$promotionNameCompany) {
  $error= "Please provide a person's or company's name.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionTitle) {
  $error= "Please provide a title.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionType) {
  $error= "Please select a type.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionTopics) {
  $error= "Please provide at least one topic.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionDescription) {
  $error= "Please provide a description.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionLink) {
  $error= "Please provide a link.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionDuration) {
  $error= "Please provide a duration.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionAmount) {
  $error= "Please provide an amount.";
  array_push($promotionErrors,$error);
  array_push($responses,$error);
}

if (!$promotionId) {

  if (!$promotionImageFileName) {
    $error= "Please upload the image.";
    array_push($promotionErrors,$error);
    array_push($responses,$error);
  }

  if (!$promotionAgreement) {
    $error= "Please upload the agreement.";
    array_push($promotionErrors,$error);
    array_push($responses,$error);
  }

}



if (!$promotionErrors) {

  $promotionDate = dcomplete_format ($currentTime);
  $promotionExpiry = dcomplete_format($currentTime + (86400 * $promotionDuration));

  $slugNameCompany = str_replace(" ","_",strtolower($promotionNameCompany));
 
  $promotionImageFileLink = $promotionImageLink;

  if ($promotionImageFileName)  {
      $promotionImageFolder = '../../uploads/promotion/image/';

      if (!is_dir($promotionImageFolder)) {
        mkdir($promotionImageFolder, 0777, true);
    }

    $promotionImageFile = $promotionImageFolder.$slugNameCompany."-".date("YmdHis",time()).".".$promotionImageFileNameActualExt;

    if (move_uploaded_file($promotionImage["tmp_name"], $promotionImageFile)) {
      $uploadOk = 1;
    }

    $promotionImageFileLink= substr($promotionImageFile,5);
  } 

  

  $promotionAgreementFileLink= $promotionAgreementLink;

  if ($promotionAgreementFileName) {
    $promotionAgreementFolder = '../../uploads/promotion/agreement/'; 

    if (!is_dir($promotionAgreementFolder)) {
        mkdir($promotionAgreementFolder, 0777, true);
    }

    $promotionAgreementFile = $promotionAgreementFolder.$slugNameCompany."-".date("YmdHis",time()).".".$promotionAgreementFileNameActualExt;

    $uploadOk = 1;

    if (move_uploaded_file($promotionAgreement["tmp_name"], $promotionAgreementFile)) {
      $uploadOk = 1;
    }
       
    $promotionAgreementFileLink= substr($promotionAgreementFile,5);

  } 
    

  if (!$promotionId) {

     $promotionStatus = "Draft";

     $sqlAddPromotion = "INSERT INTO promotions (promotionNameCompany,promotionTitle,promotionType, promotionTopics,promotionDescription,promotionImage,promotionLink,promotionDuration,promotionAmount,promotionStatus,promotionAgreement) VALUES ( ?, ?, ?, ?,?,?,?,?,?,?,?)";

    $stmt =$conn->prepare($sqlAddPromotion);

    $stmt ->bind_param("sssssssssss", $promotionNameCompany,$promotionTitle,$promotionType,$promotionTopics,$promotionDescription,$promotionImageFileLink,$promotionLink,$promotionDuration,$promotionAmount,$promotionStatus,$promotionAgreementFileLink);

    $stmt-> execute();

    echo 'Promotion Sent';

  }



  if ($promotionId) {

    

     $sqlUpdatePromotion = "UPDATE promotions 
                        SET
                        promotionNameCompany =?,
                        promotionTitle =?,
                        promotionType=?, 
                        promotionTopics=?,
                        promotionDescription=?,
                        promotionImage=?,
                        promotionLink=?,
                        promotionDuration=?,
                        promotionAmount=?,
                        promotionAgreement=?
                       WHERE promotionId=$promotionId";

    $stmt =$conn->prepare($sqlUpdatePromotion);

    $stmt ->bind_param("ssssssssss", $promotionNameCompany,$promotionTitle,$promotionType,$promotionTopics,$promotionDescription,$promotionImageFileLink,$promotionLink,$promotionDuration,$promotionAmount,$promotionAgreementFileLink);

    $stmt-> execute();

    echo 'Promotion Sent';

  }

   
   
} else {
  foreach ($responses as $response) {
        echo $response."<br>";
    }
}

  


}


if(isset($_POST['subscription_submit'])) {
            $registrantId = htmlspecialchars($_POST ['subscription_registrant_hidden_id']);
            $toolSubscriptionList = htmlspecialchars($_POST ['in_tool_subscription_list']);
            $fileSubscriptionList = htmlspecialchars($_POST ['in_file_subscription_list']);
            $sellerSubscriptionList = htmlspecialchars($_POST ['in_seller_subscription_list']);
            $teacherRegistration = htmlspecialchars($_POST ['in_teacher_registration']);

            $type = htmlspecialchars($_POST ['subscription_type']);        
            $duration = htmlspecialchars($_POST ['subscription_duration']);
            $total = htmlspecialchars($_POST ['subscription_total']);
            $paymentOption = htmlspecialchars($_POST ['subscription_payment_option']);
            $referenceNumber = htmlspecialchars($_POST ['subscription_reference_number']);

            $responses = [];
            $fileErrors = [];
            $subscriptionNotice = [];

            if (!$type) {
                array_push($responses,"Please select subscription type.");
            }

            if (!$duration) {
                array_push($responses,"Please enter subscription duration.");
            }

            if (!$paymentOption) {
                array_push($responses,"Please select payment option.");
            }

            if (!$referenceNumber) {
                array_push($responses,"Please provide reference number.");
            }
        
            
            $_SESSION ['type'] = $type;
            $_SESSION ['duration'] = $duration;
            $_SESSION ['paymentOptionName'] = $paymentOption;
            $_SESSION ['referenceNumber'] = $referenceNumber;


            $proofOfPayment = '';
            $proofOfPaymentFileName ='';
            $proofOfPaymentFileNameFileNameExt = '';
            $proofOfPaymentFileNameActualExt = '';
             

            if (isset($_FILES ['subscription_proof_of_payment'])) {

            $proofOfPayment = $_FILES ['subscription_proof_of_payment'];
            $proofOfPaymentFileName = $proofOfPayment ['name'];
            $proofOfPaymentFileNameFileNameExt = explode ('.',$proofOfPaymentFileName);
            $proofOfPaymentFileNameActualExt = strtolower(end($proofOfPaymentFileNameFileNameExt));
          
             
            } else {
                $error = 'Please provide a proof of payment.';
                array_push($fileErrors,$error);
                array_push($responses,$error);
            }
        
        
            

            $allowedExtsProofOfPayment = ['jpeg', 'jpg'];
            
                 if ($proofOfPaymentFileName && !in_array($proofOfPaymentFileNameActualExt,$allowedExtsProofOfPayment)) {
                $error = "Invalid format for proof of payment.";
                array_push($fileErrors,$error);
                array_push($responses,$error);
                
               
                } 

                if (!empty($duration)) {
                
                        if (!is_numeric($duration)) {
                                $error = "Please enter a number only for duration.";
                                array_push($fileErrors,$error);
                                array_push($responses,$error);
                
                        } else {
                                if ($duration < 1) {
                                $error = "Duration must be greater than 0.";
                                array_push($fileErrors,$error);
                                array_push($responses,$error); 
                
                                }

                        } 

                }


            

            if ($toolSubscriptionList && $type=='Tools') {
                $notice = 'Subscription for tools is disabled.';
                array_push($subscriptionNotice,$notice);
                array_push($responses,$notice);
                
                }

        if ($fileSubscriptionList && $type=='Files') {
                $notice = 'Subscription for files is disabled.';
                array_push($subscriptionNotice,$notice);
                array_push($responses,$notice);
                }

        if ($sellerSubscriptionList && $type=='Seller') {
                $notice = 'Subscription for seller is disabled.';
                array_push($subscriptionNotice,$notice);
                array_push($responses,$notice);
                }

        if (!$teacherRegistration && $type=='Seller') {
                $notice = 'Subscription for files is not allowed.';
                array_push($subscriptionNotice,$notice);
                array_push($responses,$notice);
                }


        if (!$fileErrors && !$subscriptionNotice) {
                $proofOfPaymentFolder = '../../uploads/subscription/proof/';
            
                if (!is_dir($proofOfPaymentFolder)) {
                mkdir($proofOfPaymentFolder, 0777, true);
                }

                $proofOfPaymentFile = $proofOfPaymentFolder ."userid-".$registrantId."-".date("YmdHis",time()).".".$proofOfPaymentFileNameActualExt;

                $uploadOk = 1;

              
              if (move_uploaded_file($proofOfPayment["tmp_name"], $proofOfPaymentFile)) {
                  $uploadOk = 1;
              } 

                $proofOfPaymentLink= substr($proofOfPaymentFile,5);

                
                $sql = "INSERT INTO registrant_subscriptions (registrant_subscriptionUserId,registrant_subscriptionType,registrant_subscriptionDuration,registrant_subscriptionTotal,registrant_subscriptionPaymentOption,registrant_subscriptionRefNumber,registrant_subscriptionProofOfPayment) VALUES (?, ?,?, ?, ?,?,?)";

                $stmt =$conn->prepare($sql);

                $stmt ->bind_param("sssssss", $registrantId, $type,$duration,$total,$paymentOption, $referenceNumber,$proofOfPaymentLink);

                $stmt-> execute();

                unset($_SESSION ['type']);
                unset($_SESSION ['duration']);
                unset($_SESSION ['paymentOptionName']);
                unset($_SESSION ['referenceNumber']);
                unset($_SESSION ['proofOfPayment']);

                
                echo 'Subscription Sent';
                

        } else {   
                foreach ($responses as $response) {
                echo $response ."<br>";
                }        
        }

} 




if (isset($_POST['status_promotion_submit'])) {

  $promotionId = htmlspecialchars($_POST['promotion_id']);
  $toDo = htmlspecialchars($_POST['to_do']);
  $duration = (int) htmlspecialchars($_POST['promotion_duration']);
  $status = '';

  if ($toDo == 'publish') {
    $status ="Published";

  }

  if ($toDo == 'unpublish') {
    $status ="Unpublished";
  }



  $sqlPromotionInfo = "SELECT * FROM promotions WHERE promotionId = '$promotionId'";

  $sqlPromotionInfoResult = mysqli_query($conn,$sqlPromotionInfo);
  $promotionInfo = $sqlPromotionInfoResult->fetch_assoc();

  $promotionDate = $promotionInfo ['promotionDate'] !='0000-00-00 00:00:00' ? $promotionInfo ['promotionDate'] : date("Y-m-d H:i:s", $currentTime);

  $promotionExpiry = $promotionInfo ['promotionExpiry'] !='0000-00-00 00:00:00' ? $promotionInfo ['promotionExpiry'] : date ("Y-m-d H:i:s", strtotime($promotionDate) + ($duration * 86400));


  $sqlUpdatePromotionStatus = "UPDATE promotions 
                      SET promotionStatus = ?,
                      promotionDate = ?,
                      promotionExpiry = ?
                      WHERE promotionId =  $promotionId";

  
  $stmt = mysqli_stmt_init($conn);
  $prepareStmt = mysqli_stmt_prepare($stmt, $sqlUpdatePromotionStatus);
  
  if ($prepareStmt) {
  mysqli_stmt_bind_param($stmt,"sss", $status,$promotionDate,$promotionExpiry);
  mysqli_stmt_execute($stmt);

  echo 'Promotion Status Updated';
  }
                       
}







if (isset($_POST['subscription_update'])) {

$subscriptionId=htmlspecialchars($_POST['subscription_id']);
$subscriptionType=htmlspecialchars($_POST['subscription_type']);
$toDo = htmlspecialchars($_POST['to_do']);

$sqlSubscription = "SELECT * FROM registrant_subscriptions WHERE registrant_subscriptionId = $subscriptionId";
$sqlSubscriptionResult = mysqli_query($conn,$sqlSubscription);
$subscription = $sqlSubscriptionResult->fetch_assoc();

if ($subscription){
    $subscriptionDuration = (int) $subscription ['registrant_subscriptionDuration'];
}


if($toDo=='approve') {
$status="Approved";
}

if($toDo=='reject') {
$status="Rejected";
}

if($toDo=='revoke') {
$status="Revoked";
}

if($toDo=='keep') {
$status="Kept";
}


$activation= date("Y-m-d H:i:s", $currentTime);

if ($subscriptionType=='Shelf') {
$expiry = date("Y-m-d H:i:s", $currentTime + 365.25 * 86400 * $subscriptionDuration);
} else {
   $expiry = date("Y-m-d H:i:s", $currentTime + 60 * 60 *24 *30*$subscriptionDuration); 
}


$sqlUpdateStatus =  "UPDATE registrant_subscriptions
                        SET registrant_subscriptionStatus = ?,
                        registrant_subscriptionDate=?,
                        registrant_subscriptionExpiry=?
                        WHERE registrant_subscriptionId =$subscriptionId";

    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sqlUpdateStatus);
    
    if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"sss",$status,$activation,$expiry);
    mysqli_stmt_execute($stmt);

echo 'Subscription status updated!';

}

}







if (isset($_POST['registration_update_submit'])) {

$registrationId= htmlspecialchars($_POST['registration_id']);
$regType =htmlspecialchars($_POST['regtype']);
$toDo = htmlspecialchars($_POST['to_do']);

if ($toDo=="approve") {
    $profileStatus="Approved";
}

if ($toDo=="reject") {
    $profileStatus="Rejected";
}


if ($toDo=="revoke") {
    $profileStatus="Revoked";
}

if ($toDo=="keep") {
    $profileStatus="Kept";
}



if ($regType) {

    $approvalDate = date("Y-m-d H:i:s", $currentTime);

    $sqlUpdateStatus =  "UPDATE other_registrations
                            SET otherStatus = ?,
                            otherApprovalDate = ?
                            WHERE otherId = '$registrationId'";

    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sqlUpdateStatus);
    
    if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"ss",$profileStatus,$approvalDate);
    mysqli_stmt_execute($stmt);

    
    //Update the general registrations
    $regTypeCap = ucfirst($regType);

    if ($profileStatus =="Approved" || $profileStatus =="Kept" ) {
        $regRoleStatus=$regTypeCap;
    } 

    if ($profileStatus !="Approved" && $profileStatus !="Kept" ) {
        $regRoleStatus='';
    }


    $regRoleAccountCol = 'registrant'.$regTypeCap.'Account';

    $sqlOtherRegistrant = "SELECT * FROM other_registrations WHERE otherId = $registrationId";
    $sqlOtherRegistrantResult = mysqli_query($conn,$sqlOtherRegistrant);
    $otherRegistrant = $sqlOtherRegistrantResult->fetch_assoc();

    if ($otherRegistrant) {
        $otherRegistrantMainId = $otherRegistrant['otherUserId'];
    }


    $sqlUpdateRegistrantRoleAccount = "UPDATE registrations SET $regRoleAccountCol = ?
                        WHERE registrantId = '$otherRegistrantMainId'";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sqlUpdateRegistrantRoleAccount);

    if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"s",$regRoleStatus);
    mysqli_stmt_execute($stmt);  

    }

}
}

if (!$regType) {

    $sqlUpdateRegistrantStatus = "UPDATE registrations SET registrantStatus = ?
                            WHERE registrantId = '$registrationId'";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sqlUpdateRegistrantStatus);

    if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"s",$profileStatus);
    mysqli_stmt_execute($stmt); 
    }


}

echo "You updated the registration.";

    
}


if (isset($_POST['note_submit'])) {

$notes= htmlspecialchars($_POST['note_notes']);
$userIdHidden = htmlspecialchars($_POST['note_userid']);
$regTypeCap = htmlspecialchars($_POST['note_regtype']);
$regType = htmlspecialchars($_POST['note_regtype_cap']);



 $sqlUpdateNotes = "UPDATE other_registrations 
                        SET otherNotes =?
                        WHERE otherUserId = $userIdHidden AND otherType='$regTypeCap'";

                         $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sqlUpdateNotes);
    
    if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"s", $notes);
    mysqli_stmt_execute($stmt);

   echo 'Notes updated successfully!';
  }


}




if (isset($_POST['delete_record_submit'])){
    $recordCategory = htmlspecialchars($_POST['record_category']);
    $recordId = htmlspecialchars($_POST['record_id']);

    if ($recordCategory == 'General Registration'){

    }

    echo "Deleted successfully!";

}





if (isset($_POST['get_promotions_submit'])) {
    $contentType = htmlspecialchars($_POST['content_type']);
    $searchedPromotion = htmlspecialchars($_POST['searched_promotion']);




    $sqlPromotionsCreteria = "promotions WHERE promotionStatus = 'Published' ORDER BY promotionId DESC LIMIT 1";
    if ($searchedPromotion) {
         $sqlPromotionsCreteria = "promotions WHERE promotionStatus = 'Published' AND promotionCode="."'".$searchedPromotion."'"." ORDER BY promotionId DESC LIMIT 1";
    }
   
    // $sqlCount = 
    $sqlPromotionsRecords = "SELECT * FROM ".$sqlPromotionsCreteria;
    $sqlPromotionsResult = mysqli_query($conn, $sqlPromotionsRecords);


    if ($sqlPromotionsResult->num_rows>0){
        while($promotions = $sqlPromotionsResult->fetch_assoc()) {
            $promotionsId = $promotions ['promotionId'];
            $promotionTitle = $promotions ['promotionTitle'];
            $promotionImage= $privateFolder.$promotions ['promotionImage'];
            $promotionLink = $promotions ['promotionLink'];



            echo "
            <a href='".$promotionLink."'>
                <small>Advertisement</smal>
                <img src='$promotionImage' style='width:100%;'>
                <p><strong>$promotionTitle</strong></p>
            </a>
           
            ";
        }
    } else {
        echo "
            <p>No promotion</p>
        ";
    }





}















