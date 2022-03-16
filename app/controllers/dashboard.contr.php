<?php

class Dashboard extends Controller
{
    public function index()
    {
        $this->view('home/index', [

        ]);
    }

    public function login()
    {
        $this->view('login/index', [

        ]);
    }

    
}