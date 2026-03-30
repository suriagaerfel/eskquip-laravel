
<?php require app_path('Includes/initialize.php'); ?>

@php
    $pageName = 'Terms of Use';
@endphp

@include('components/main')
@extends('components/main')

@section ('content')
    @include('components/page-articles')
@endsection
