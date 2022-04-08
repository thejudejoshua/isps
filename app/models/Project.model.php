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

                return "success!=/projects/metrics/".$array['project name']."/".$project_id."/".$array['project sector'];
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
            $query = "SELECT * FROM `projects` WHERE `metrics` != '0'";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getAllActiveUserSectorProjects($sector)
    {
        try{
            $query = "SELECT * FROM `projects` WHERE `metrics` != '0' AND `sector` = :sector AND `approved` = '1' AND `suspended` != '1' ORDER BY `score` DESC";
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

    public function getUnapprovedProjects($sector)
    {
        try{
            $query = "SELECT * FROM `projects` WHERE `metrics` != '0' AND `approved` = '0' AND `sector`=:sector AND `suspended` != '1'";
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

    public function getSuspendedProjects($sector)
    {
        try{
            $query = "SELECT * FROM `projects` WHERE `metrics` != '0' AND `sector`=:sector AND `suspended` = '1'";
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

    public function getProjectData($id)
    {
        try{
            $query = "SELECT * FROM `projects` JOIN `projects_details` WHERE `projects_details`.`project_id` = `projects`.`id` AND `projects`.`id`=:id";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':id' => $id
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
        
    }

    public function getProjectMetrics($table_prefix, $id)
    {
        try{
            $query = "SELECT * FROM `".$table_prefix."_projects_metrics` WHERE `".$table_prefix."_projects_metrics`.`project_id`=:id";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':id' => $id
            ]);
            $data = $stmt->fetchAll();
            return $data;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
        
    }

    public function getProjectMetricsScores($table_prefix, $id)
    {
        try{
            $query = "SELECT * FROM `".$table_prefix."_projects_metrics` JOIN `".$table_prefix."_projects_scores` WHERE `".$table_prefix."_projects_metrics`.`id` = `".$table_prefix."_projects_scores`.`metrics_id` AND `".$table_prefix."_projects_metrics`.`project_id`=:id";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':id' => $id
            ]);
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

    public function addProjectPriority($id)
    {
        try{
            $insert = "INSERT INTO `priority_list`(`project_id`) VALUES (:id)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                ':id' => $id
            ]);
            return true;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function addProjectExecution($id)
    {
        try{
            $insert = "INSERT INTO `execution_list`(`project_id`) VALUES (:id)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                ':id' => $id
            ]);
            return true;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function approveproject($id, $approved_by, $approved_by_designation)
    {
        try{
            $update = "UPDATE `projects` SET `approved` = '1', `approved_by` = :approved_by, `approved_by_designation` = :approved_by_designation WHERE `id` = :id";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                ':approved_by' => $approved_by,
                ':approved_by_designation' => $approved_by_designation,
                ':id' => $id
            ]);
            return 'success!=You have successfully approved this project!';
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function suspendproject($id, $suspender, $suspended_by_designation, $suspension_date)
    {
        try{
            $update = "UPDATE `projects` SET `suspended` = '1', `suspended_by` = ?, `suspended_by_designation` = ?, `date_suspended` = ? WHERE `id` = ?";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                $suspender,
                $suspended_by_designation,
                $suspension_date,
                $id
            ]);
            return true;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function reactivateProject($id, $suspender, $suspended_by_designation, $suspension_date, $approved, $approved_by,$approved_by_designation)
    {
        try{
            $update = "UPDATE `projects` SET `suspended` = '0', `suspended_by` = ?, `suspended_by_designation` = ?, `date_suspended` = ?, `approved` = ?, `approved_by` = ?,  `approved_by_designation` = ? WHERE `id` = ?";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                $suspender,
                $suspended_by_designation,
                $suspension_date,
                $approved,
                $approved_by,
                $approved_by_designation,
                $id
            ]);
            return true;
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function editProject($array)
    {
        try
        {
            $update = "UPDATE `projects` SET `name` = ?, `description` = ?, `startYear` = ?, `duration` = ?, `cost` = ?, `sector` = ?, `year_of_entry` = ? WHERE id=?";
            $stmt = $this->connect()->prepare($update);

            if($stmt->execute([
                $array['project name'],
                $array['project description'],
                $array['project start year'],
                $array['project duration'],
                $array['project cost'],
                $array['project sector'],
                $array['year_of_entry'],
                $array['project_id']
            ])
            ){
                $update_details = "UPDATE `projects_details` SET `origin_state` = ?, `origin_lga` = ?, `origin_longitude` = ?, `origin_latitude` = ?, `midway_points` = ?, `midway_state` = ?, `midway_lga` = ?, `midway_longitude` = ?, `midway_latitude` = ?, `destination_state` = ?, `destination_lga` = ?, `destination_longitude` = ?, `destination_latitude` = ? WHERE `project_id` = ?";
                $stmt = $this->connect()->prepare($update_details);
                $stmt->execute([
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
                    $array['destination_latitude'],
                    $array['project_id']
                ]);

                return "success!=/edit/metrics/".$array['project name']."/".$array['project_id']."/".$array['project sector'];
            }
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }

    }

    public function table_prefix($sector){
        switch ($sector) {
            case 'Railway Construction':
                $table_prefix = 'railway';
                break;
            
            case 'Highway Construction':
                $table_prefix = 'highway';
                break;

            case 'Power Generation':
                $table_prefix = 'power_gen';
                break;
            
            case 'Power Transmission':
                $table_prefix = 'power_trans';
                break;

            case 'Water Supply':
                $table_prefix = 'water';
                break;
        }
        return $table_prefix;
    }

    public function getCompared($array, $keyToCompare)
    {
        $sum = 0;
        foreach ($array as $key => $value) {
            $sum += $value[$keyToCompare];
            $average = $sum/count($array);
        }
        return $average;
    }


}