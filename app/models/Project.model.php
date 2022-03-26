<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

class Project extends Db
{
    public function __construct()
    {
        $session = new Session;
        $session->startSession();
    }

    public function getLGA($state)
    {
        try{
            $query = "SELECT * FROM `states` WHERE `state` = :state";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':state' => $state
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getState($state)
    {
        try{
            $query = "SELECT `state` FROM states WHERE `state` like :state ORDER BY state ASC";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':state' => $state,
            ]);
            if($stmt->rowCount() == 0){
                return "error=State does not exist. Check again";
            }else{
                $data = $stmt->fetchAll();
                return $data;
            }
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getAllStates()
    {
        try{
            $query = "SELECT `state` FROM states";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            if($stmt->rowCount() == 0){
                return "error=Could not retrieve all states. Try again!";
            }else{
                $data = $stmt->fetchAll();
                return $data;
            }
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getLngLat($state)
    {
        try{
            $query = "SELECT `lat`, `lng` FROM states WHERE `state` = :state";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':state' => $state,
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function addProject($array)
    {
        try
        {
            $insert = "INSERT INTO `projects`(`name`, `description`, `startYear`, `duration`, `cost`, `sector`, `year_of_entry`, `added_by`, `added_by_designation`, `approved`, `metrics`, `date_added`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);

            if($stmt->execute([
                $array['project name'],
                $array['project description'],
                $array['project start year'],
                $array['project duration'],
                $array['project cost'],
                $array['project sector'],
                $array['year_of_entry'],
                $array['added_by'],
                $array['added_by_designation'],
                $array['approved'],
                $array['metrics'],
                $array['date_added']])
            ){
                $project_id = $this->connect()->lastInsertId();
                $insert_details = "INSERT INTO `projects_details`(`project_id`, `origin_state`, `origin_lga`, `origin_longitude`, `origin_latitude`, `midway_points`, `midway_state`, `midway_lga`, `midway_longitude`, `midway_latitude`, `destination_state`, `destination_lga`, `destination_longitude`, `destination_latitude`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $this->connect()->prepare($insert_details);
                $stmt->execute([
                    $project_id,
                    $array['project origin state'],
                    $array['project origin lga'],
                    $array['origin_longitude'],
                    $array['origin_latitude'],
                    $array['midway_points'],
                    $array['midway_state'],
                    $array['midway_lga'],
                    $array['midway_longitude'],
                    $array['midway_latitude'],
                    $array['project destination state'],
                    $array['project destination lga'],
                    $array['destination_longitude'],
                    $array['destination_latitude']
                ]);

                return "success!=/projects/add_metrics/".$array['project name']."/".$project_id."/".$array['project sector'];
            }
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
        
    }

    public function findEmptyMetrics($user)
    {
        try{
            $query = "SELECT `id`, `name`, `sector` FROM `projects` WHERE `metrics` = '0' AND `added_by` = :user LIMIT 1";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':user' => $user
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getAllProjects()
    {
        try{
            $query = "SELECT `id`, `name`, `sector`, `score`, `rank` FROM `projects` WHERE `metrics` != '0'";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getMetrics($sector)
    {
        try{
            $query = "SELECT `metrics`.`sector_id`, `metrics`.`metrics_data`, `sectors`.`sector_name` FROM `metrics` JOIN `sectors` WHERE `metrics`.`sector_id` = `sectors`.`id`!= '0' AND `sectors`.`sector_name`= :sector";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':sector' => $sector
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getSectorList()
    {
        try{
            $query = "SELECT `sector_name` FROM `sectors`";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }
}