<?php

    session_destroy();

    $get = new Redirect; //initialize redirect class
    $home = '/';
    $get->redirectTo($home); //initialize redirect