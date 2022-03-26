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

            $input = $this->model('Input');
            $user = $this->model('User');
    
            $this->view('login/index', [
    
            ]);

        }
        
    }
    
}