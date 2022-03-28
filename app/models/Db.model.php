<?php

class Db
{
    //Connect to the database
    private $host = 'localhost';
    private $usernm = 'judegniz_Jude';
    private $password = 'Felenous12#';
    private $dbName = 'judegniz_isps';
    
    
    protected function connect(){//try database connection
        static $dbConn;
        try {
            if (!$dbConn) {
                date_default_timezone_set('Africa/Lagos');
                $dbd = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
                $dbConn = new PDO($dbd, $this->usernm, $this->password);
                $dbConn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);// set the PDO fetch mode to fetch_assoc
                $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);// set the PDO error mode to warning
             }
            //echo "Connected to database successfully!";
            return $dbConn;
        } catch (PDOException $e) {
            echo "Connection failed: " . die($e->getMessage());
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
