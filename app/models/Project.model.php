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
            $insert = "INSERT INTO `railway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Average_Daily_Customers_or_Cargo`, `Volume_to_Capacity_Ratio`, `Railway_Classification`, `Macro_Corridor_Completion`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
                $array['Creates_job_opportunities_for_other_regions'],
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
            $insert = "INSERT INTO `railway_projects_scores`(`metrics_id`, `Construction_Type`, `Average_Daily_Customers_or_Cargo`, `Volume_to_Capacity_Ratio`, `Railway_Classification`, `Macro_Corridor_Completion`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
                $array['Creates_job_opportunities_for_other_regions'],
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
            $insert = "INSERT INTO `highway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Average_Daily_Traffic`, `Volume_to_Capacity_Ratio`, `Roadway_Classification`, `Macro_Corridor_Completion`, `Accident_Rate`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['project_id'],
                $array['sector'],
                $array['Construction_Type'],
                $array['Average_Daily_Traffic'],
                $array['Volume_to_Capacity_Ratio'],
                $array['Roadway_Classification'],
                $array['Macro_Corridor_Completion'],
                $array['Accident_Rate'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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
            $insert = "INSERT INTO `highway_projects_scores`(`metrics_id`, `Construction_Type`, `Average_Daily_Traffic`, `Volume_to_Capacity_Ratio`, `Roadway_Classification`, `Macro_Corridor_Completion`, `Accident_Rate`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Unique_Multimodal_Impacts`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['metrics_id'],
                $array['Construction_Type'],
                $array['Average_Daily_Traffic'],
                $array['Volume_to_Capacity_Ratio'],
                $array['Roadway_Classification'],
                $array['Macro_Corridor_Completion'],
                $array['Accident_Rate'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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

    public function addpower_genProjectMetrics($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Type_of_technology`, `General_Capacity`, `Availability_of_Technical_personnel`, `Availability_of_replacement_parts`, `Availability_of_major_energy_source`, `Presence_of_Anchor_customers_or_Industrial_clusters`, `Has_a_Power_Purchase_Agreement_been_executed?`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Availability_of_access_roads_to_plant,_security`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['project_id'],
                $array['sector'],
                $array['Construction_Type'],
                $array['Type_of_technology'],
                $array['General_Capacity'],
                $array['Availability_of_Technical_personnel'],
                $array['Availability_of_replacement_parts'],
                $array['Availability_of_major_energy_source'],
                $array['Presence_of_Anchor_customers_or_Industrial_clusters'],
                $array['Has_a_Power_Purchase_Agreement_been_executed?'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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
                $array['Availability_of_access_roads_to_plant,_security'],
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

    public function addpower_genProjectScores($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_scores`(`metrics_id`, `Construction_Type`, `Type_of_technology`, `General_Capacity`, `Availability_of_Technical_personnel`, `Availability_of_replacement_parts`, `Availability_of_major_energy_source`, `Presence_of_Anchor_customers_or_Industrial_clusters`, `Has_a_Power_Purchase_Agreement_been_executed?`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Availability_of_access_roads_to_plant,_security`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['metrics_id'],
                $array['Construction_Type'],
                $array['Type_of_technology'],
                $array['General_Capacity'],
                $array['Availability_of_Technical_personnel'],
                $array['Availability_of_replacement_parts'],
                $array['Availability_of_major_energy_source'],
                $array['Presence_of_Anchor_customers_or_Industrial_clusters'],
                $array['Has_a_Power_Purchase_Agreement_been_executed?'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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
                $array['Availability_of_access_roads_to_plant,_security'],
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

    public function addpower_transProjectMetrics($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Type_of_transmission_line`, `Length_of_transmission_infrastructure`, `Availability_of_Technical_personnel`, `Availability_of_replacement_parts`, `Availability_of_distribution_grid_offtake`, `Presence_of_Anchor_customers_or_Industrial_clusters`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['project_id'],
                $array['sector'],
                $array['Construction_Type'],
                $array['Type_of_transmission_line'],
                $array['Length_of_transmission_infrastructure'],
                $array['Availability_of_Technical_personnel'],
                $array['Availability_of_replacement_parts'],
                $array['Availability_of_distribution_grid_offtake'],
                $array['Presence_of_Anchor_customers_or_Industrial_clusters'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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

    public function addpower_transProjectScores($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_scores`(`metrics_id`, `Construction_Type`, `Type_of_transmission_line`, `Length_of_transmission_infrastructure`, `Availability_of_Technical_personnel`, `Availability_of_replacement_parts`, `Availability_of_distribution_grid_offtake`, `Presence_of_Anchor_customers_or_Industrial_clusters`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['metrics_id'],
                $array['Construction_Type'],
                $array['Type_of_transmission_line'],
                $array['Length_of_transmission_infrastructure'],
                $array['Availability_of_Technical_personnel'],
                $array['Availability_of_replacement_parts'],
                $array['Availability_of_distribution_grid_offtake'],
                $array['Presence_of_Anchor_customers_or_Industrial_clusters'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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

    public function addwaterProjectMetrics($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_metrics`(`project_id`, `sector`, `Construction_Type`, `Type_of_technology`, `Capacity_of_water_containment_structure`, `Availability_of_Technical_personnel`, `Availability_of_replacement_parts`, `Availability_of_major_energy_source`, `Are_there_water_supply_pipes_and_associated_facilities_in_place?`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Availability_of_access_roads_to_plant,_security`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['project_id'],
                $array['sector'],
                $array['Construction_Type'],
                $array['Type_of_technology'],
                $array['Capacity_of_water_containment_structure'],
                $array['Availability_of_Technical_personnel'],
                $array['Availability_of_replacement_parts'],
                $array['Availability_of_major_energy_source'],
                $array['Are_there_water_supply_pipes_and_associated_facilities_in_place?'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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
                $array['Availability_of_access_roads_to_plant,_security'],
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

    public function addwaterProjectScores($array)
    {
        try
        {
            $insert = "INSERT INTO `highway_projects_scores`(`metrics_id`, `Construction_Type`, `Type_of_technology`, `Capacity_of_water_containment_structure`, `Availability_of_Technical_personnel`, `Availability_of_replacement_parts`, `Availability_of_major_energy_source`, `Are_there_water_supply_pipes_and_associated_facilities_in_place?`, `Enhances_Inter-regional_Trade`, `Economic_benefits_to_other_regions`, `Creates_job_opportunities_for_other_regions`, `Number_of_jobs_created`, `Number_of_jobs_that_would_be_retained`, `GDP_of_local_economy_(state)`, `Cost_Effectiveness_(cost/average_daily_traffic)`, `Project_cost_(amount_to_be_spent_by_government)`, `Investment_Payback_Period_(in_years)`, `Compensation_and_Relocation`, `Population_to_be_served`, `Ability_to_mitigate_against_environmental_degradation`, `Amount_of_Co2_Emmissions_from_the_project`, `Environmental_Impact_Category`, `Waste_management_policy`, `Occupational_Health_and_Safety_policy`, `Use_of_naturally_occuring_materials_within_the_corridor`, `Private/Public/Local_Participation`, `Availability_of_access_roads_to_plant,_security`, `Ability_to_spur_urban_renewal/compliment_key_business_activities`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($insert);
            $stmt->execute([
                $array['metrics_id'],
                $array['Construction_Type'],
                $array['Type_of_technology'],
                $array['Capacity_of_water_containment_structure'],
                $array['Availability_of_Technical_personnel'],
                $array['Availability_of_replacement_parts'],
                $array['Availability_of_major_energy_source'],
                $array['Are_there_water_supply_pipes_and_associated_facilities_in_place?'],
                $array['Enhances_Inter-regional_Trade'],
                $array['Economic_benefits_to_other_regions'],
                $array['Creates_job_opportunities_for_other_regions'],
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
                $array['Availability_of_access_roads_to_plant,_security'],
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


}