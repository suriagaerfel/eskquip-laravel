<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index (){
        $registrantId = 1;
        $publicFolder=config('app.publicFolder');
        $privateFolder=config('app.privateFolder');
        $currentTime = config('app.currentTime');

        if ($registrantId) {

                        $myRecords = Registration::where('registrantId',1)->first();
                     
                        return view('components.main',compact($myRecords));
                            

                        
                                
            
                            
        } 
    }
}
