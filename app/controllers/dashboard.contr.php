<?php

class Dashboard extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $login = '/login';
            $redirect->redirectTo($login);
            
        }else{
            $this->views('dashboard/index', [
    
            ]);
        }
    }
    
}