<?php

class Session
{
    public function startSession(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function destroySessions(){
        session_destroy();
    }

    public function unsetSession($sessionVar){
        unset($sessionVar);
    }

}