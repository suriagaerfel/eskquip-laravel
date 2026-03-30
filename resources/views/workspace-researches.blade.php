
<?php require app_path('Includes/initialize.php'); ?>

@php
    $pageName = 'School Workspace - Researches';
@endphp

@include('components/main')

@extends ('components/main')


@section('content')
    @include('components/workspace-page')
@endsection