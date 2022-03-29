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

    public function addrailwayProjectMetrics($array)
    {
        try
        {
            $insert = "INSERT INTO `railway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Average_Daily_Customers_or_Cargo`, `Volume_to_Capacity_Ratio`, `Railway_Classification`, `Macro_Corridor_Completion`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_oppotunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['project_id'],
                $array['sector'],
                $array['Construction_Type'],
                $array['Average_Daily_Customers_or_Cargo'],
                $array['Volume_to_Capacity_Ratio'],
                $array['Railway_Classification'],
                $array['Macro_Corridor_Completion'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_oppotunities_for_other_regions'],
                $array['Number_of_jobs_created'],
                $array['Number_of_jobs_that_would_be_retained'],
                $array['GDP_of_local_economy_(state)'],
                $array['Cost_Effectiveness_(cost/average_daily_traffic)'],
                $array['Project_cost_(amount_to_be_spent_by_government)'],
                $array['Investment_Payback_Period_(in_years)'],
                $array['Compensation_and_Relocation'],
                $array['Population_to_be_served'],
                $array['Ability_to_mitigate_against_environmental_degradation'],
                $array['Amount_of_Co2_Emmissions_from_the_project'],
                $array['Environmental_Impact_Category'],
                $array['Waste_management_policy'],
                $array['Occupational_Health_and_Safety_policy'],
                $array['Use_of_naturally_occuring_materials_within_the_corridor'],
                $array['Private/Public/Local_Participation'],
                $array['Unique_Multimodal_Impacts'],
                $array['Ability_to_spur_urban_renewal/compliment_key_business_activities']
            ]);
            $metrics_id = $this->connect()->lastInsertId();

            $update = "UPDATE `projects` SET `metrics` = '1' WHERE `id` = :id";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                ':id' => $array['project_id']
            ]);

            return $metrics_id;
                
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function addrailwayProjectScores($array)
    {
        try
        {
            $insert = "INSERT INTO `railway_projects_scores`(`metrics_id`, `Construction_Type`, `Average_Daily_Customers_or_Cargo`, `Volume_to_Capacity_Ratio`, `Railway_Classification`, `Macro_Corridor_Completion`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_oppotunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['metrics_id'],
                $array['Construction_Type'],
                $array['Average_Daily_Customers_or_Cargo'],
                $array['Volume_to_Capacity_Ratio'],
                $array['Railway_Classification'],
                $array['Macro_Corridor_Completion'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_oppotunities_for_other_regions'],
                $array['Number_of_jobs_created'],
                $array['Number_of_jobs_that_would_be_retained'],
                $array['GDP_of_local_economy_(state)'],
                $array['Cost_Effectiveness_(cost/average_daily_traffic)'],
                $array['Project_cost_(amount_to_be_spent_by_government)'],
                $array['Investment_Payback_Period_(in_years)'],
                $array['Compensation_and_Relocation'],
                $array['Population_to_be_served'],
                $array['Ability_to_mitigate_against_environmental_degradation'],
                $array['Amount_of_Co2_Emmissions_from_the_project'],
                $array['Environmental_Impact_Category'],
                $array['Waste_management_policy'],
                $array['Occupational_Health_and_Safety_policy'],
                $array['Use_of_naturally_occuring_materials_within_the_corridor'],
                $array['Private/Public/Local_Participation'],
                $array['Unique_Multimodal_Impacts'],
                $array['Ability_to_spur_urban_renewal/compliment_key_business_activities']
            ]);

            $update = "UPDATE `projects` SET `score` = :score WHERE `id` = :id";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                ':score' => $array['total_score'],
                ':id' => $array['project_id']
            ]);

            return 'success!=/projects';
                
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function addhighwayProjectMetrics($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Average_Daily_Traffic`, `Volume_to_Capacity_Ratio`, `Roadway_Classification`, `Macro_Corridor_Completion`, `Accident_Rate`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_oppotunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['project_id'],
                $array['sector'],
                $array['Construction_Type'],
                $array['Average_Daily_Traffic'],
                $array['Volume_to_Capacity_Ratio'],
                $array['Road_Classification'],
                $array['Macro_Corridor_Completion'],
                $array['Accident_Rate'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_oppotunities_for_other_regions'],
                $array['Number_of_jobs_created'],
                $array['Number_of_jobs_that_would_be_retained'],
                $array['GDP_of_local_economy_(state)'],
                $array['Cost_Effectiveness_(cost/average_daily_traffic)'],
                $array['Project_cost_(amount_to_be_spent_by_government)'],
                $array['Investment_Payback_Period_(in_years)'],
                $array['Compensation_and_Relocation'],
                $array['Population_to_be_served'],
                $array['Ability_to_mitigate_against_environmental_degradation'],
                $array['Amount_of_Co2_Emmissions_from_the_project'],
                $array['Environmental_Impact_Category'],
                $array['Waste_management_policy'],
                $array['Occupational_Health_and_Safety_policy'],
                $array['Use_of_naturally_occuring_materials_within_the_corridor'],
                $array['Private/Public/Local_Participation'],
                $array['Unique_Multimodal_Impacts'],
                $array['Ability_to_spur_urban_renewal/compliment_key_business_activities']
            ]);
            $metrics_id = $this->connect()->lastInsertId();

            $update = "UPDATE `projects` SET `metrics` = '1' WHERE `id` = :id";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                ':id' => $array['project_id']
            ]);

            return $metrics_id;
                
        }catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function addhighwayProjectScores($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_scores`(`metrics_id`, `Construction_Type`, `Average_Daily_Traffic`, `Volume_to_Capacity_Ratio`, `Roadway_Classification`, `Macro_Corridor_Completion`, `Accident_Rate`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_oppotunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['metrics_id'],
                $array['Construction_Type'],
                $array['Average_Daily_Traffic'],
                $array['Volume_to_Capacity_Ratio'],
                $array['Road_Classification'],
                $array['Macro_Corridor_Completion'],
                $array['Accident_Rate'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_oppotunities_for_other_regions'],
                $array['Number_of_jobs_created'],
                $array['Number_of_jobs_that_would_be_retained'],
                $array['GDP_of_local_economy_(state)'],
                $array['Cost_Effectiveness_(cost/average_daily_traffic)'],
                $array['Project_cost_(amount_to_be_spent_by_government)'],
                $array['Investment_Payback_Period_(in_years)'],
                $array['Compensation_and_Relocation'],
                $array['Population_to_be_served'],
                $array['Ability_to_mitigate_against_environmental_degradation'],
                $array['Amount_of_Co2_Emmissions_from_the_project'],
                $array['Environmental_Impact_Category'],
                $array['Waste_management_policy'],
                $array['Occupational_Health_and_Safety_policy'],
                $array['Use_of_naturally_occuring_materials_within_the_corridor'],
                $array['Private/Public/Local_Participation'],
                $array['Unique_Multimodal_Impacts'],
                $array['Ability_to_spur_urban_renewal/compliment_key_business_activities']
            ]);

            $update = "UPDATE `projects` SET `score` = :score WHERE `id` = :id";
            $stmt = $this->connect()->prepare($update);
            $stmt->execute([
                ':score' => $array['total_score'],
                ':id' => $array['project_id']
            ]);

            return 'success!=/projects';
                
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

    public function getAllUserSectorProjects($sector)
    {
        try{
            $query = "SELECT * FROM `projects` WHERE `metrics` != '0' AND `sector` = :sector ORDER BY `score` DESC";
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
            $query = "SELECT * FROM `projects` WHERE `metrics` != '0' AND `approved` = '0' AND `sector`=:sector";
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
            $query = "SELECT * FROM `projects` WHERE `id` = :id";
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
}