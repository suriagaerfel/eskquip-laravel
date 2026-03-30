
<?php require app_path('Includes/initialize.php'); ?>

@php
    $pageName = 'My Account';
@endphp

@include('components/main')

@extends ('components/main')



@section('content')
    <div id="account-page" class="page with-sidebars-page">
    
  
        <div id="account-page-account-details" class="page-details account-details">    
                @include('components/profile')
            
                <div class="account-menus">
                <?php if ($type=='Personal') {?>
            
                <button class="link-tag-button" id="show-my-subscription-button">My Subscription</button>
                <?php } ?>

                <button class="link-tag-button" id="show-other-registration-button">Other Registration</button>
                

                <?php if ($haveOtherRegistration) {?>
                <button class="link-tag-button" id="show-workspace-button">My Workspace</button>
                <?php } ?>

            </div>
        </div>                           

    </div>


@endsection
