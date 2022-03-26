<?php

spl_autoload_register(
    function($model){
        $fullPath = "../../../app/models/" . $model . ".model.php";
        if(!file_exists($fullPath)){
            return false;
        }else{
            include_once $fullPath;
        }
    }
);