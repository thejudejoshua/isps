<?php

class Redirect
{
    public function redirectTo($target) {
        header('location: '. $target);
        exit;
    }
}