<?php

Class User extends Db
{
    public function __construct()
    {
        $session = new Session;
        $session->startSession();
    }

    public function addDev($array)
    {
        $email = $array[0];
        $password = $array[1];

        try{
            $send = "INSERT INTO `dev_admin` set
                    `email` = :email,
                    `password` = :password";
            $stmt = $this->connect()->prepare($send);
            $stmt->execute([
                ':email' => $email,
                ':password' => $password
            ]);
            return true;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function logUser($array)
    {
        $email = $array['email'];
        $password = $array['password'];

        try{
            $send = "SELECT `id`, `name`, `password` FROM `dev_admin` where `email` = :email";
            $stmt = $this->connect()->prepare($send);
            $stmt->execute([
                ':email' => $email
            ]);
            if($stmt->rowCount() == 0){
                return "error=Your email does not exist in our records. Try again.";
            }else{
                $data = $stmt->fetchAll();
                foreach($data as $data){
                    $id = $data['id'];
                    $name = $data['name'];
                    $sys_password = $data['password'];
                }
                if (password_verify($password, $sys_password)){
                    $_SESSION['id'] = $id;
                    $_SESSION['logged'] = '1';
                    $_SESSION['name'] = $name;
                    return "success!";
                }else{
                    return "error=The password you entered is incorrect. Try again.";
                }
            }
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

}