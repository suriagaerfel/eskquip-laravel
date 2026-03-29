<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/articles', function () {
    return view('articles');
});




Route::get('/articles/read/{slug}', function ($slug) {
    // You can fetch the article from the database here
    return view('articles', ['slug' => $slug]);
});


Route::get('/{user}', function ($user) {
    // You can fetch the article from the database here
    return view('home', ['user' => $user]);
});
