<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\AccountRecordsService;
use Illuminate\Support\Facades\View;


class PageController extends Controller
{

    protected $acount_records;

    protected $publicFolder;

    public function __construct(AccountRecordsService $service)
    {
      

        $registrantCode = session('registrant-code');

        $this->acount_records = $service->get_profile_records($registrantCode);
        $records= $this->acount_records;

        View::share($records);


        $this->publicFolder = config('app.publicFolder');


    }








    public function home(AccountRecordsService $service){

        $user=null;
        
        $pageName = 'Home';

        return view ('home', compact('pageName','user'));
        
    }



     public function user ($user, AccountRecordsService $service){

        if ($user){
            $user_records = DB::table('registrations')->where('registrantUsername', $user)->first();

            $user_code = $user_records->registrantCode;
            $accountName = $user_records->registrantAccountName;

            $pageName = $accountName;

            $user_records =  $service->get_profile_records($user_code);

        }
        

        return view ('user', compact('pageName','user'));
        
    }




    public function articles ($slug=null,$category=null,$date=null,$tag=null){
        $pageName = 'Articles';
        return view ('articles', compact('pageName','slug','category','date','tag'));
    }

    public function teacher_files (){
        $pageName = 'Teacher Files';
        return view ('teacher-files', compact('pageName'));
    }

    public function researches (){
        $pageName = 'Researches';
        return view ('researches', compact('pageName'));
    }

    public function tools (){
        $pageName = 'Tools';
        return view ('tools', compact('pageName'));
    }

    public function login (){
        $pageName = 'Login';
        $user=null;

        $publicFolder= $this->publicFolder;
        $loggedIn= $this->acount_records['accountName'];

         if($loggedIn){
            return redirect($publicFolder.'/account');
        }

        return view ('login', compact('pageName','user'));
    }

    public function create_account (){
        $pageName = 'Create Account';

        $publicFolder= $this->publicFolder;
        $loggedIn= $this->acount_records['accountName'];

         if($loggedIn){
            return redirect($publicFolder.'/account');
        }



        return view ('create-account', compact('pageName'));
    }

     public function get_passsword_reset_link (){
        $pageName = 'Get Password Reset Link';
        return view ('get-password-reset-link', compact('pageName'));
    }

    public function reset_password (){
        $pageName = 'Reset Password';
        return view ('reset-password', compact('pageName'));
    }


      public function account (){
        $pageName = 'My Account';
        $user=null;

        $publicFolder= $this->publicFolder;
         $loggedIn= $this->acount_records['accountName'];

         if(!$loggedIn){
            return redirect($publicFolder.'/login');
        }
        
        return view ('account', compact('pageName','user'));
    }

    public function workspace_writer (){
        $pageName = 'Workspace - Writer';
        return view ('workspace.writer', compact('pageName'));
    }

     public function workspace_editor (){
        $pageName = 'Workspace - Editor';
        return view ('workspace.editor', compact('pageName'));
    }

     public function workspace_teacher (){
        $pageName = 'Workspace - Teacher';
        return view ('workspace.teacher', compact('pageName'));
    }

     public function workspace_developer (){
        $pageName = 'Workspace - Developer';
        return view ('workspace.developer', compact('pageName'));
    }

     public function workspace_researches (){
        $pageName = 'School Workspace - Researches';
        return view ('workspace.researches', compact('pageName'));
    }






    public function messages (){
         $pageName = 'Messages';

         $publicFolder= $this->publicFolder;
         $loggedIn= $this->acount_records['accountName'];

         if(!$loggedIn){
            return redirect($publicFolder.'/login');
        }

        return view ('workspace.researches', compact('pageName'));
    }
}
