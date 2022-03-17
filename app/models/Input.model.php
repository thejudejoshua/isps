<?php


class Input
{

    public function devAddInput($email, $password)
    {
        $dev_email = $email;
        $dev_password = password_hash($password, PASSWORD_BCRYPT, array("cost" == 10));

        return $array = [$dev_email, $dev_password];
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