<?php


class Login extends Controller
{
    protected $user;
    protected $input;
    
    public function index()
    {
        if(isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);

        }else{

            $input = new Input;
            $user = new User;
    
            $this->view('login/index', [
    
            ]);

        }
        
    }
    
}