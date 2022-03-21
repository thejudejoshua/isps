<?php

class Db
{
    //Connect to the database
    private $host = 'localhost';
    private $usernm = 'firstmf1_Ubyjude';
    private $password = '6yY]?*_Nem{p';
    private $dbName = 'isps';


    protected function connect(){//try database connection
        try {
            date_default_timezone_set('Africa/Lagos');
            $dbd = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
            $dbConn = new PDO($dbd, $this->usernm, $this->password);
            $dbConn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);// set the PDO fetch mode to fetch_assoc
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception
            //echo "Connected to database successfully!";
            return $dbConn;
        } catch (PDOException $e) {
            echo "Connection failed: " . die($e->getMessage());
        }
    }

}
