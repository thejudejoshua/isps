<?php


class Login extends Controller
{
    protected $user;
    protected $input;
    
    public function index()
    {

        $input = new Input;
        $user = new User;

        $this->view('login/index', [

        ]);
        
    }

    
}