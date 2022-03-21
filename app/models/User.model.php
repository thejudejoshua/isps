<?php

Class User extends Db
{
    public function __construct()
    {
        $session = new Session;
        $session->startSession();
    }

    public function addUser($array)
    {
        try{
            $send = "INSERT INTO `".$array['designation']."` set
                    `firstName` = ?,
                    `lastName` = ?,
                    `email` = ?,
                    `phone` = ?,
                    `sector` = ?,
                    `designation` = ?,
                    `level` = ?,
                    `added_by` = ?,
                    `added_by_sector` = ?,
                    `added_by_designation` = ?,
                    `password` = ?";
            $stmt = $this->connect()->prepare($send);
            $stmt->execute([
                $array['first name'],
                $array['last name'],
                $array['email'],
                $array['phone number'],
                $array['sector'],
                $array['designation'],
                $array['rank'],
                $array['added_by'],
                $array['added_by_sector'],
                $array['added_by_designation'],
                $array['password']
            ]);
            return "success!";
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function logUser($array)
    {
        $email = $array['email'];
        $password = $array['password'];

        try{
            $send = "SELECT `dev_admin`.`id`, `dev_admin`.`firstName`, `dev_admin`.`lastName`, `dev_admin`.`designation`, `dev_admin`.`sector`, `dev_admin`.`password` FROM `dev_admin`WHERE`dev_admin`.`email` = :email
                    UNION ALL
                    SELECT `budgeting officer`.`id`, `budgeting officer`.`firstName`, `budgeting officer`.`lastName`, `budgeting officer`.`designation`, `budgeting officer`.`sector`, `budgeting officer`.`password` FROM `budgeting officer` WHERE `budgeting officer`.`email` = :email
                    UNION ALL
                    SELECT `director`.`id`, `director`.`firstName`, `director`.`lastName`, `director`.`designation`, `director`.`sector`, `director`.`password` FROM `director` WHERE `director`.`email` = :email
                    UNION ALL
                    SELECT `secretariat`.`id`, `secretariat`.`firstName`, `secretariat`.`lastName`,`secretariat`.`designation`,`secretariat`.`sector`, `secretariat`.`password` FROM `secretariat` WHERE `secretariat`.`email` = :email";

            $stmt = $this->connect()->prepare($send);
            $stmt->execute([
                ':email' => $email,
                ':email' => $email,
                ':email' => $email,
                ':email' => $email
            ]);
            if($stmt->rowCount() == 0){
                return "error=Your email does not exist in our records. Try again.";
            }else{
                $data = $stmt->fetchAll();
                foreach($data as $data){
                    $id = $data['id'];
                    $name = $data['firstName']. ' '. $data['lastName'];
                    $sys_password = $data['password'];
                    $designation = $data['designation'];
                    $sector = $data['sector'];
                }
                if (password_verify($password, $sys_password)){
                    $_SESSION['id'] = $id;
                    $_SESSION['logged'] = '1';
                    $_SESSION['name'] = $name;
                    $_SESSION['designation'] = $designation;
                    $_SESSION['sector'] = $sector;
                    return "success!";
                }else{
                    return "error=The password you entered is incorrect. Try again.";
                }
            }
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getAllUsers()
    {
        try{
            $get = "SELECT `secretariat`.`id`,`secretariat`.`firstName`, `secretariat`.`lastName`, `secretariat`.`sector`, `secretariat`.`designation`, `secretariat`.`email`, `secretariat`.`date_added` FROM `secretariat`
            UNION ALL
            SELECT `director`.`id`,`director`.`firstName`, `director`.`lastName`, `director`.`sector`, `director`.`designation`,`director`.`email`, `director`.`date_added` FROM `director`
            UNION ALL
            SELECT `budgeting officer`.`id`,`budgeting officer`.`firstName`, `budgeting officer`.`lastName`, `budgeting officer`.`sector`, `budgeting officer`.`designation`, `budgeting officer`.`email`, `budgeting officer`.`date_added` FROM `budgeting officer`";
            $stmt = $this->connect()->prepare($get);
            $stmt->execute([]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getUserData($id, $role)
    {
        try{
            $get = "SELECT `id`, `firstName`, `lastName`, `email`, `phone`, `sector`, `designation`, `level`, `added_by`, `added_by_designation`, `added_by_sector`, `date_added` FROM `secretariat` WHERE `id` = :id AND `designation` = :role
                    UNION ALL
                    SELECT `id`, `firstName`, `lastName`, `email`, `phone`, `sector`, `designation`, `level`, `added_by`, `added_by_designation`, `added_by_sector`, `date_added` FROM `director` WHERE `id` = :id  AND `designation` = :role
                    UNION ALL
                    SELECT `id`, `firstName`, `lastName`, `email`, `phone`, `sector`, `designation`, `level`, `added_by`, `added_by_designation`, `added_by_sector`, `date_added` FROM `budgeting officer` WHERE `id` = :id AND `designation` = :role";

            $stmt = $this->connect()->prepare($get);
            $stmt->execute([
                ':id' => $id,
                ':role' => $role,
                ':id' => $id,
                ':role' => $role,
                ':id' => $id,
                ':role' => $role
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function runQuery($sql)//inset query to run to database
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return false;
        }else{
            $data = $stmt->fetchAll();
            return $data;
        }
    }
}