<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;




class BaseController extends Controller
{
    
    public function index (){
        Session::pull('registrant-code','');

        return view('main');
    }

}


