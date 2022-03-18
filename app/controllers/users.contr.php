<?php

class Users extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $user = $this->model('User');
            $usersList = $user->getAllUsers();

            $this->view('users/index', [
                'usersList' => $usersList
            ]);
        }
    }

    public function add_user()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            $this->view('users/add_user/index', [
    
            ]);
        }
    }
    
}