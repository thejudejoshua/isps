<?php

require_once 'config.php';

$project = new Project();

switch($_POST){
    case isset($_POST['project_id']):
        switch (true) {
            default:
            
                $name = NULL;
                $designation = NULL;
                $suspended_date = NULL;
                $approved = '1';
                $approved_by = $_SESSION['name'];
                $approved_by_designation = $_SESSION['designation'];
                $date_approved = date("Y-m-d");

                $reactivate = $project->reactivateProject($_POST['project_id'], $name, $designation, $suspended_date, $approved, $approved_by, $approved_by_designation, $date_approved);

                if($reactivate == true)
                {
                    $table_prefix = $project->table_prefix($_SESSION['sector']);
                    
                    $metricsData = $project->getMetrics($_SESSION['sector']);
                    $allProjects  = $project->getAllActiveUserSectorProjects($_SESSION['sector']);
                    foreach ($metricsData as $key => $metrics){
                        $metricsData = json_decode($metrics['metrics_data'], TRUE);
                    }

                    foreach ($allProjects as $key => $value) {
                        $projectMetricsData = $project->getProjectMetrics($table_prefix, $allProjects[$key]['id']);//get the metrics data for each of the projects
                        
                        foreach($metricsData as $key => $val){//breakdown the sector metrics for each of the remaining active projects
                            foreach($val as $key => $metrics){
                                foreach($metrics as $key => $label){
                                    foreach ($projectMetricsData[0] as $formDataKey => $value) {
                                        $newDataKey = str_replace('_', ' ', $formDataKey); //remove the underscore from the form-input names as in the $array
                                        if($newDataKey === $label['label']){
                                            if($label['element'] == 'select')
                                            {
                                                $projectMetricsData[0][$formDataKey] = $label['options'][$value];
                                            }else
                                            {
                                                $sql = "SELECT `".$table_prefix."_projects_metrics`.`id`, `".$table_prefix."_projects_metrics`.`".$formDataKey."` FROM `".$table_prefix."_projects_metrics` JOIN `projects` WHERE `".$table_prefix."_projects_metrics`.`project_id` = `projects`.`id` AND `projects`.`suspended` != '1' ORDER BY `".$formDataKey."` DESC";
                                                $metrics_result = $project->runSelectQuery($sql);    
                                                
                                                foreach ($metrics_result as $metrics_resultKey => $metrics_resultData)
                                                {
                                                    
                                                    $compared = $project->getCompared($metrics_result, $formDataKey, $metrics_resultData[$formDataKey]);
                                                    
                                                    if($formDataKey == 'Investment_Payback_Period_(in_years)' && $metrics_resultData[$formDataKey] == '0'){
                                                        $newScore[$formDataKey] = $label['data-score']['No-Payback'];
                                                    }
                                                    else
                                                    {                
                                                        if($compared == 'Low')
                                                        {
                                                            $newScore[$formDataKey] = $label['data-score'][$compared];
                                                        }elseif($compared == 'Medium')
                                                        {
                                                            $newScore[$formDataKey] = $label['data-score'][$compared];
                                                        }elseif($compared == 'High')
                                                        {
                                                            $newScore[$formDataKey] = $label['data-score'][$compared];
                                                        }
                                                    }

                                                    $old_metrics_id = $metrics_resultData['id'];

                                                    $sql = "UPDATE `".$table_prefix."_projects_scores` SET `".$formDataKey."` = '".$newScore[$formDataKey]."' WHERE `metrics_id` = '".$old_metrics_id."'";
                                                    $project->runInsertQuery($sql);

                                                    $query = "SELECT `".$table_prefix."_projects_scores`.*, `".$table_prefix."_projects_metrics`.`project_id` FROM `".$table_prefix."_projects_scores` JOIN `".$table_prefix."_projects_metrics` WHERE `".$table_prefix."_projects_scores`.`metrics_id` = '".$old_metrics_id."' AND `".$table_prefix."_projects_scores`.`metrics_id` = `".$table_prefix."_projects_metrics`.`id`";
                                                    $oldMetricsList = $project->runSelectQuery($query)[0];
                                    
                                                    $oldProjectID = $oldMetricsList['project_id'];
                                                    
                                                    array_shift($oldMetricsList);
                                                    array_shift($oldMetricsList);
                                                    array_pop($oldMetricsList);
                                    
                                                    $oldMetricsTotalScore = array_sum($oldMetricsList);
                                        
                                                    $update_old_project_score = "UPDATE `projects` SET `score` = ".$oldMetricsTotalScore." WHERE `id` = ".$oldProjectID."";
                                                    $project->runInsertQuery($update_old_project_score);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    echo 'success!=You have successfully re-activated this project!';
                }else{
                    echo $reactivate;
                }
            break;
        }
    break;
}
