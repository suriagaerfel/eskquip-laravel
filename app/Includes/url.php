<?php 
// Get the scheme (http or https)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

// Get the host (domain name, with optional port number)
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];

// Combine them to form the base URL
$domain = $scheme . '://' . $host;


$publicFolder= $domain.'/'; 

if(str_contains($domain,'localhost')){
    $projectName = '/eskquip-laravel';
    $domain = $domain.$projectName;

    $publicFolder= $domain.'/public'; 
    $privateFolder=$domain.'/private';
}



?>