<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;


Route::get('/', function () {
    
    return view('home');
});

Route::get('/articles', function () {
    return view('articles');
});

Route::get('/teacher-files', function () {
    return view('teacher-files');
});

Route::get('/researches', function () {
    return view('researches');
});

Route::get('/tools', function () {
    return view('tools');
});


Route::get('/login', function () {
    return view('login');
});

Route::get('/create-account', function () {
    return view('create-account');
});

Route::get('/account', function () {
    return view('account');
});


Route::get('/get-password-reset-link', function () {
    return view('get-password-reset-link');
});

Route::get('/reset-password', function () {
    return view('reset-password');
});

Route::get('/search', function () {
    return view('search');
});


Route::get('/messages', function () {
    return view('messages');
});

Route::get('/about-us', function () {
    return view('about-us');
});

Route::get('/terms-of-use', function () {
    return view('terms-of-use');
});

Route::get('/data-privacy', function () {
    return view('data-privacy');
});




Route::get('/workspace/writer', function () {
    return view('workspace-writer');
});

Route::get('/workspace/editor', function () {
    return view('workspace-editor');
});

Route::get('/workspace/teacher', function () {
    return view('workspace-teacher');
});

Route::get('/workspace/researches', function () {
    return view('workspace-researches');
});

Route::get('/workspace/developer', function () {
    return view('workspace-developer');
});

Route::get('/workspace/website-manager', function () {
    return view('workspace-website-manager');
});









Route::get('/articles/read/{slug}', function ($slug) {
    return view('articles', ['slug' => $slug]);
});

Route::get('/articles/category/{category}', function ($category) {
    return view('articles', ['category' => $category]);
});

Route::get('/articles/tag/{tag}', function ($tag) {
    return view('articles', ['tag' => $tag]);
});

Route::get('/articles/writer/{owner}', function ($owner) {
    return view('articles', ['owner' => $owner]);
});

Route::get('/articles/date/{date}', function ($date) {
    return view('articles', ['date' => $date]);
});



Route::get('/teacher-files/view/{slug}', function ($slug) {
    return view('teacher-files', ['slug' => $slug]);
});


Route::get('/teacher-files/category/{category}', function ($category) {
    return view('teacher-files', ['category' => $category]);
});

Route::get('/teacher-files/tag/{tag}', function ($tag) {
    return view('teacher-files', ['tag' => $tag]);
});

Route::get('/teacher-files/teacher/{owner}', function ($owner) {
    return view('teacher-files', ['owner' => $owner]);
});

Route::get('/teacher-files/date/{date}', function ($date) {
    return view('teacher-files', ['date' => $date]);
});






Route::get('/researches/view/{slug}', function ($slug) {
    return view('researches', ['slug' => $slug]);
});

Route::get('/researches/category/{category}', function ($category) {
    return view('researches', ['category' => $category]);
});

Route::get('/researches/tag/{tag}', function ($tag) {
    return view('researches', ['tag' => $tag]);
});

Route::get('/researches/school/{owner}', function ($owner) {
    return view('researches', ['owner' => $owner]);
});

Route::get('/researches/date/{date}', function ($date) {
    return view('researches', ['date' => $date]);
});





Route::get('/tools/category/{category}', function ($category) {
    return view('tools', ['category' => $category]);
});

Route::get('/tools/tag/{tag}', function ($tag) {
    return view('tools', ['tag' => $tag]);
});

Route::get('/tools/developer/{owner}', function ($owner) {
    return view('tools', ['owner' => $owner]);
});

Route::get('/tools/date/{date}', function ($date) {
    return view('tools', ['date' => $date]);
});







Route::get('/{user}', function ($user) {
    return view('home', ['user' => $user]);
});


Route::post('/get-profile', [AccountController::class, 'get_profile']);
Route::post('/login', [AccountController::class, 'login']);
Route::post('/create-account', [AccountController::class, 'create_account']);
Route::post('/send-verification-link', [AccountController::class, 'send_verification_link']);
Route::post('/verify/{verification-code}', [AccountController::class, 'send_verification_link']);
Route::get('/verify/{registrantCode}/{verificationCode}', [AccountController::class, 'verify']);
Route::post('/logout', [AccountController::class, 'logout_ajax']);
Route::get('/logout/{user_id}/{token}', [AccountController::class, 'logout_email']);
Route::post('/send-logout-link', [AccountController::class, 'send_logout_link']);
