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

                $suspend = $project->reactivateProject($_POST['project_id'], $name, $designation, $suspended_date, $approved, $approved_by, $approved_by_designation);

                if($suspend == true)
                {
                    switch ($_SESSION['sector']) {
                        case 'Railway Construction':
                            $table_prefix = 'railway';
                            break;
                        
                        case 'Highway Construction':
                            $table_prefix = 'highway';
                            break;
                    }
                    
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
                                                $input = str_replace(',', '', $value);//remove all the commas from input formatting
                                                $sql = "SELECT `".$table_prefix."_projects_metrics`.`id`, `".$table_prefix."_projects_metrics`.`".$formDataKey."` FROM `".$table_prefix."_projects_metrics` JOIN `projects` WHERE `".$table_prefix."_projects_metrics`.`project_id` = `projects`.`id` AND `projects`.`suspended` != '1' ORDER BY `".$formDataKey."` DESC";
                                                $result = $project->runSelectQuery($sql);
                                                
                                                foreach ($result as $resultKey => $resultData)
                                                {
                                                    $matches = array_search($resultData, $result) + 1;
                                                    if($matches < ceil(count($result)/2))
                                                    {
                                                        $newScore = $label['data-score']['High'];
                                                    }elseif($matches > ceil(count($result)/2))
                                                    {
                                                        $newScore = $label['data-score']['Low'];
                                                    }else
                                                    {
                                                        $newScore = $label['data-score']['Medium'];
                                                    }

                                                    $sql = "UPDATE `".$table_prefix."_projects_scores` SET `".$formDataKey."` = ".$newScore." WHERE `metrics_id` = ".$resultData['id']."";
                                                    $project->runInsertQuery($sql);
                                                    
                                                    $query = "SELECT * FROM `".$table_prefix."_projects_scores` WHERE `metrics_id` = ".$resultData['id']."";
                                                    $oldMetricsList = ($project->runSelectQuery($query))[0];
                                                    array_shift($oldMetricsList);
                                                    array_shift($oldMetricsList);
                                                    $oldMetricsTotalScore = array_sum($oldMetricsList);
                                                    
                                                    $query = "SELECT `".$table_prefix."_projects_metrics`.`project_id` FROM `".$table_prefix."_projects_metrics` WHERE `".$table_prefix."_projects_metrics`.`id` = ".$resultData['id']."";
                                                    $oldProjectID = ($project->runSelectQuery($query))[0];
                                                    $oldProjectID['project_id'];

                                                    $update = "UPDATE `projects` SET `score` = ".$oldMetricsTotalScore." WHERE `id` = ".$oldProjectID['project_id']."";
                                                    $project->runInsertQuery($update);
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
                    echo $suspend;
                }
            break;
        }
    break;
}
