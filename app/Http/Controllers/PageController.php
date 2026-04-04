<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\AccountRecordsService;
use Illuminate\Support\Facades\View;


class PageController extends Controller
{

    protected $account_records;

    protected $publicFolder;

    public function __construct(AccountRecordsService $service)
    {
      

        $registrantCode = session('registrant-code');

        $this->account_records = $service->get_profile_records($registrantCode);
        $records= $this->account_records;

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

         $user=null;

        $publicFolder= $this->publicFolder;
       

        return view ('articles', compact('pageName','user','slug','date'));
   
    }


    public function teacher_files ($slug=null,$category=null,$date=null,$tag=null){
        $pageName = 'Teacher Files';
        $user=null;

        return view ('teacher-files', compact('pageName','user','slug','date'));
    }

    public function researches ($slug=null,$category=null,$date=null,$tag=null){
        $pageName = 'Researches';
        $user=null;

        $publicFolder= $this->publicFolder;
        return view ('researches', compact('pageName','user','slug','date'));
       
    }

    public function tools ($slug=null,$category=null,$date=null,$tag=null){
        $pageName = 'Tools';

        $user=null;

        $publicFolder= $this->publicFolder;
        return view ('tools', compact('pageName','user','slug','date'));
   
    }

    public function login (){
        $pageName = 'Login';
        $user=null;

        $publicFolder= $this->publicFolder;
        $loggedIn= $this->account_records['accountName'];

         if($loggedIn){
            return redirect($publicFolder.'/account');
        }

        return view ('login', compact('pageName','user'));
    }

    public function create_account (){
        $pageName = 'Create Account';

        $user=null;

        $publicFolder= $this->publicFolder;
        $loggedIn= $this->account_records['accountName'];

         if($loggedIn){
            return redirect($publicFolder.'/account');
        }

        return view ('create-account', compact('pageName','user'));
    }

     public function get_password_reset_link (){
        $pageName = 'Get Password Reset Link';

        $user=null;

        $publicFolder= $this->publicFolder;
        $loggedIn= $this->account_records['accountName'];

         if($loggedIn){
            return redirect($publicFolder.'/account');
        }

        return view ('get-password-reset-link', compact('pageName','user'));
    }

    public function reset_password (){
        $pageName = 'Reset Password';
        return view ('reset-password', compact('pageName'));
    }


      public function account (){
        $pageName = 'My Account';
        $user=null;

        $publicFolder= $this->publicFolder;
         $loggedIn= $this->account_records['accountName'];

         if(!$loggedIn){
            return redirect($publicFolder.'/login');
        }
        
        return view ('account', compact('pageName','user'));
    }

    public function workspace_writer (){
        $pageName = 'Workspace - Writer';
        $user=null;

        $publicFolder= $this->publicFolder;
        $writerRegistration = $this->account_records['writerRegistration'];

        if (!$writerRegistration){
            return redirect($publicFolder.'/account');
        }

        return view ('workspace.writer', compact('pageName','user'));
    }

     public function workspace_editor (){
        $pageName = 'Workspace - Editor';
        $user=null;

        $publicFolder= $this->publicFolder;
        $editorRegistration = $this->account_records['editorRegistration'];

        if (!$editorRegistration){
            return redirect($publicFolder.'/account');
        }

        return view ('workspace.editor', compact('pageName','user'));
    }

     public function workspace_teacher (){
        $pageName = 'Workspace - Teacher';
        $user=null;

        $publicFolder= $this->publicFolder;
        $teacherRegistration = $this->account_records['teacherRegistration'];

        if (!$teacherRegistration){
            return redirect($publicFolder.'/account');
        }

        return view ('workspace.teacher', compact('pageName','user'));
    }

     public function workspace_developer (){
        $pageName = 'Workspace - Developer';
        $user=null;

        $publicFolder= $this->publicFolder;
        $developerRegistration = $this->account_records['developerRegistration'];

        if (!$developerRegistration){
            return redirect($publicFolder.'/account');
        }

        return view ('workspace.developer', compact('pageName','user'));
    }

     public function workspace_researches (){
        $pageName = 'School Workspace - Researches';
        $user=null;

        $publicFolder= $this->publicFolder;
        $researchesRegistration = $this->account_records['reserachesRegistration'];

        if (!$researchesRegistration){
            return redirect($publicFolder.'/account');
        }

        return view ('workspace.researches', compact('pageName','user'));
    }

    public function workspace_website_manager (){
        $pageName = 'Workspace - Webiste Manager';
        $user=null;

        $publicFolder= $this->publicFolder;
        $websiteManagerRegistration = $this->account_records['websiteManagerRegistration'];

        if (!$websiteManagerRegistration){
            return redirect($publicFolder.'/account');
        }

        return view ('workspace.website-manager', compact('pageName','user'));
    }






    public function messages (){
         $pageName = 'Messages';

         $publicFolder= $this->publicFolder;
         $loggedIn= $this->account_records['loggedIn'];

         if(!$loggedIn){
            return redirect($publicFolder.'/login');
        }

        return view ('workspace.researches', compact('pageName'));
    }


    public function search(){
        $pageName = 'Search';

        $user=null;
        return view ('search', compact('pageName','user'));

    }
}
