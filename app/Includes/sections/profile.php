<div id="profile">
        <div id="profile-top">
                
                <div id="cover-photo-container">
                    <img id="cover-photo">
                </div>
                 <?php if ($registrantId){?>
                <div id="cover-photo-camera-container">
                    <img src="<?php echo $website.'/assets/images/camera.svg'?>" id="cover-photo-camera-icon" class="icon profile-details-icon">
                </div>
                <?php } ?>
              
                <div id="profile-picture-summary">
                    <div id="profile-picture-container">
                        <img id="profile-picture">   
                        <?php if ($registrantId){?>
                            <div id="profile-picture-camera-container">
                                <img src="<?php echo $website.'/assets/images/camera.svg'?>" 
                                id="profile-camera-icon" class="icon profile-details-icon">
                            </div>
                        <?php } ?>
                    </div>
                    <div id="profile-summary">
                        <h4 id="profile-account-name-view"></h4>
                        <p id="profile-registrations-view"></p>
                    </div>
                </div>
        </div>

        <div style="margin-top: 80px;">
             <em class="profile-details-view" id="profile-description-view-searched"></em>
        </div>
       
           
        <?php if ($registrantId){?>
        <div id="profile-details">    
            <div id="profile-details-top">
                <h5 id="details">My Details</h5>
                <?php if ($registrantId){?>
                <div id="edit-profile-details-button">
                    <img src="<?php echo $website.'/assets/images/edit.svg'?>">
                </div> 
                <?php } ?>
            </div>

            <em class="profile-details-view" id="profile-description-view"></em>
        
            <hr>

            <div id="profile-details-bottom">
                <div class="profile-details-group">
                       
                        <?php if ($type=='Personal') { ?>
                            
                            <p class="profile-details-view" id="profile-first-name-view"></p>
                        
                            <p class="profile-details-view" id="profile-middle-name-view"></p>
                            
                            <p class="profile-details-view" id="profile-last-name-view"></p>
                        
                        <?php } ?>

                        <?php if($type=='School') {?>
                            <p class="profile-details-view" id="profile-school-name-view"></p>
                            <p class="profile-details-view" id="profile-school-category-view"></p>      
                        <?php } ?>

                        <p class="profile-details-view" id="profile-username-view"></p>
                        <p class="profile-details-view" id="profile-email-address-view"></p>
                        <p class="profile-details-view" id="profile-mobile-number-view"></p>
                </div>

                <?php if ($type=='Personal') { ?>
                <div class="profile-details-group" > 
                        <p class="profile-details-view" id="profile-birthdate-view"></p>  
                        <p class="profile-details-view" id="profile-gender-view"></p>                           
                        <p class="profile-details-view" id="profile-civil-status-view"></p>
                        <p class="profile-details-view" id="profile-educational-attainment-view"></p>
                        <p class="profile-details-view" id="profile-school-view"></p>
                        <p class="profile-details-view" id="profile-occupation-view"></p>
                </div>

                <?php } ?>
 
                <div class="profile-details-group">
                        
                    <p class="profile-details-view" id="profile-region-view"></p> 
                    <p class="profile-details-view" id="profile-province-state-view"></p>
                    <p class="profile-details-view" id="profile-city-municipality-view"></p>
                    <p class="profile-details-view" id="profile-barangay-view"></p>
                    <p class="profile-details-view" id="profile-street-subd-village-view"></p>  
                </div>
                
            </div>

    </div>        
    <?php } ?>     
</div>









            

          






