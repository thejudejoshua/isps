<?php

require_once 'config.php';

switch($_POST){
    case isset($_POST['email']):
        switch (true) {
            default:
                $array = ['email'=>$_POST['email'],'password'=>$_POST['password']];

                $user = new User;
                $input = new Input;

                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true){
                    $checkEmail = $input->checkEmail($array['email']);
                    if ($checkEmail == $array['email']) {
                        
                        $array = $input->sanitizeInput($array);

                        echo $user->logUser($array);
                    }else{
                        echo $checkEmail;
                    }
                }else{
                    echo $emptyCheck;
                }
            break;
        }
    break;
}
