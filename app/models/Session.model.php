<?php

class Session
{
    public function startSession(){
        session_start();
    }

    public function destroySessions(){
        session_destroy();
    }

    public function unsetSession($sessionVar){
        unset($sessionVar);
    }

}