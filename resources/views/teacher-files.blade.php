
<?php require app_path('Includes/initialize.php'); ?>
<?php require app_path('Includes/processing/content-handlers.php');?>
<?php $pageName = $contentTitle ? $contentTitle : 'Teacher Files'?>


@include('components/main')


@extends ('components/main')


@section('content')
    @include('components/content')
@endsection
