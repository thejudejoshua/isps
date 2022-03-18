<?php


class Input
{

    public function checkPassword($password, $confirmPassword)
    {
        if($password != $confirmPassword){
            return 'error=The Password and it\'s confirmation do not match. Try again.';
        }else{
            return $password;
        }

    }

    public static function sanitizeInput($array)
    {
        foreach ($array as $value) {
            $value = htmlspecialchars($value);
        }
        return $array;
    }

    public static function checkEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        }else{
            return 'error=You entered an email incorrectly. Try again.';
        }
    }

    public static function caseEmpty($array)
    {
        foreach ($array as $key => $value) {
            if(empty($array[$key])){
                return 'error=You did not enter an input for '.$key.'';
            }
        }
        return true;
    }

}