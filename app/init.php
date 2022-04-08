<?php

spl_autoload_register(
    function($cFile){
        $path = "../app/core/";
        $extension = ".php";
        $fullPath = $path . $cFile . $extension;
        if(!file_exists($fullPath)){
            //echo "The requested file - " . $cFile . ", was not found!".$fullPath;
            return false;
        }else{
            include_once $fullPath;
        }
    }
);


spl_autoload_register(
    function($contrFile){
        $path = "../app/controllers/";
        $extension = ".contr.php";
        $fullPath = $path . $contrFile . $extension;
        if(!file_exists($fullPath)){
            // echo "The requested file - " . $contrFile . ", was not found!".$fullPath;
            //return false;
            $classPath = "../app/models/";
            $classExtension = ".model.php";
            $fullClassPath = $classPath . $contrFile . $classExtension;
            if(!file_exists($fullClassPath)){
                //echo "The requested file - " . $classes . ", was not found!".$fullClassPath;
                return false;
            }else{
                include_once $fullClassPath;
            }
        }else{
            include_once $fullPath;
        }
    }
);

