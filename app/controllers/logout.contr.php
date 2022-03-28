<?php

    class Logout extends Controller
    {
        public function index()
        {
            $this->views('logout/index', []);
        }

    }