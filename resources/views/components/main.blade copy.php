

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="icon" href="{{asset('images/eskquip-icon-new.png')}}">
   <title>{{$pageName}}</title>
   

    <!-- include libraries(jQuery) -->
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{asset('js/jquery-4.0.0.min.js')}}"></script>

   
    <!-- include libraries(bootstrap) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" >
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  
    
    

    <!-- include summernote css/js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" >
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <!-- include font awesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- include my website's own css -->
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/eskquip-text-editor.css')}}">
    <link rel="stylesheet" href="{{asset('css/media-queries.css')}}">
 

</head>




<body>

    <input type="text" id="website-name-hidden" value="<?php echo $publicFolder;?>" hidden >
    <input type="text" id="page-name" value="<?php echo $pageName;?>" hidden >
    <input type="text" id="registrant-id" value="<?php echo $registrantId;?>" hidden >
    <?php if ($registrantId) {?>
    <input type="text" id="registrant-code" value="<?php echo $registrantCode; ?>" hidden>
    <?php  } ?>
    <input type="text" id="account-name" value="<?php echo $accountName;?>"  hidden>
    <input type="text" id="private-folder" value="<?php echo $privateFolder;?>" hidden>
    <input type="text" id="public-folder" value="<?php echo $publicFolder;?>" hidden>
    <input type="text" id="home-searched-user" value="<?php echo $user;?>"hidden>
    <input type="text" id="content-slug" value="<?php echo $slug; ?>" hidden>
   



    <?php if ($pageName != 'Create Account' && $pageName != 'Login' && $pageName != 'Get Password Link') {?>
    <div class="header">
        <div class="logo-container">
            <a href="<?php echo $publicFolder;?>">
                <img src="<?php echo asset('images/EskQuip-new3.png');?>" alt="EskQuip logo" class="logo" title="EskQuip">
            </a>
        </div>

        <div class="page-navigation-container">
            @include('components/header-page-navigation')
        </div>
        <img src="{{ asset('images/caret-down.svg')}}" class="icon header-icon show-mobile-navigation" id="show-mobile-navigation" onclick="toggleMobileTabletNavigation()">

        <img src="{{ asset('images/caret-up.svg')}}" class="icon header-icon hide-mobile-navigation" id="hide-mobile-navigation" onclick="toggleMobileTabletNavigation()">
            
        
        <?php if ($pageName !='Search'){ ?> 
        
        <div id="header-search-container" class="search-container">
            <a href="<?php echo $publicFolder.'/search'?>">
                <img src="{{ asset('images/header-search.svg')}}"  title="Search" style="width: 25px; cursor:pointer;">
            </a>
        </div>
        <?php }?>

        <div id="account-container" style="display: flex; gap:10px;">
                <?php if ($registrantId) {?>
                <div>
                    <a id="updates-button"><img src="{{ asset('images/update.svg')}}" class="header-icon" title="Updates"></a>
                            
                </div>

                    <div>
                    <span id="unread-updates-counter" style="display: none;" class="counter"></span>
                </div>
                <?php } ?>
                            
                    

                <?php if (!$loggedIn) {?>
                    <div id="account-not-loggedin">

                    <?php if ($pageName !='Login') { ?>

                    <a href="<?php echo $publicFolder.'/login';?>" class="header-link">Login</a>

                    <?php } ?>

                    

                    <?php if ($pageName !='Create Account' && $pageName !='Login') {?>

                    <a class="header-link">/</a>

                    <?php } ?>

                    

                        <?php if ($pageName !='Create Account') {?>

                    <a href="<?php echo $publicFolder.'/create-account/';?>" class="header-link">Create Account</a>

                    <?php } ?>




                    

                    </div>
                    <?php } else {?>

                    <div id="account-loggedin">
                            <div>
                                    <a>
                                <img src="{{ asset('images/message.svg')}}" class="header-icon message" title="Messages">
                            </a>

                            </div>
                            
                            
                                    <span id="unread-messages-counter" style="display: none;" class="counter"></span>
                            
                            
                        
                            <a href="<?php echo $publicFolder.'/account/'?>"><img src="<?=$profilePictureLink?>" class="header-icon header-profile-image" alt="<?php echo $accountName.' Profile Picture';?>"id='header-profile-picture'></a>

                            <span class="header-link" id="header-account-name"><?php echo $accountName?></span>
                                                            
                            <a id="logout-button"><img src="{{ asset('images/logout.svg')}}" class="header-icon" title="Logout" ></a>
                    
                    </div>


                    <?php } ?>

                
        </div>


    </div>

    @include ('components/website-modal')

    <div class="page-navigation-container-mobile-tablet" id="page-navigation-container-mobile-tablet">
           @include ('components/header-page-navigation')
    </div>

    <?php } ?>


   

    @yield ('content')

    @include ('components/footer')



    
</body>
</html>






