<?php

class Errors extends Controller
{
    public function index()
    {
        $this->views('500/index', [

        ]);
    }

    public function not_found()
    {
        $this->views('404/index', [

        ]);
    }

    public function restricted()
    {
        $this->views('403/index', [

        ]);
    }

    
}