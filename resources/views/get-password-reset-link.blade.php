
<?php require app_path('Includes/initialize.php'); ?>



<?php 
$pageName = 'Get Password Reset Link';
$credential = isset($_SESSION['email_username']) ? $_SESSION['email_username'] :"";

?>

@include('components/main')

@extends ('components/main')

@section('content')

<div id="get-reset-link-page" class="page form-page">

    <div class="form-page-content-container">

        @include('components/home-sidebar')

        <div class="form-section">

            <div id="get-link-form" >
                   
                <div id="get-reset-password-link-message" class="alert alert-danger" style="display: none;"></div>
                <h5 class="form-title">Provide Details</h5>
                <input type="text" id="get-reset-password-link-credential" placeholder="Email address o username">
                <button id="get-password-reset-link-submit-button">Get Password Reset Link</button>   
            </div>
        </div>

    </div>





</div>

@endsection