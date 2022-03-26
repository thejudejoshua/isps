<?php

class Errors extends Controller
{
    public function index()
    {
        $this->view('500/index', [

        ]);
    }

    public function not_found()
    {
        $this->view('404/index', [

        ]);
    }

    public function restricted()
    {
        $this->view('403/index', [

        ]);
    }

    
}