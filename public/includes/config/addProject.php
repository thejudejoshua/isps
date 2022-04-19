<?php

require_once 'config.php';

switch($_POST){
    case isset($_POST['projectName']):
        switch (true) {
            default:
                $project = new Project;
                $input = new Input;

                $array = [
                    'project name'=>$_POST['projectName'],
                    'project description'=>$_POST['projectDescription'],
                    'project start year'=>$_POST['projectStartYear'],
                    'project duration'=>$_POST['projectDuration'],
                    'project cost'=>is_numeric($_POST['projectCost']) ? $_POST['projectCost'] : str_replace( ',', '', $_POST['projectCost']),
                    'project origin state'=>$_POST['originState'],
                    'project origin lga'=>isset($_POST['originLGA']) ? $_POST['originLGA'] : '',
                    'project destination state'=>$_POST['destinationState'],
                    'project destination lga'=>isset($_POST['destinationLGA']) ? $_POST['destinationLGA'] : '',
                ];
                
                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true){
                    $midway_points = $_POST['midwayPoints'] != '' ? $_POST['midwayPoints'] : '0';

                    if($midway_points >= 1){
                        $midway_state = filter_var_array($_POST["midwayState"]);
                        $midway_lga = filter_var_array($_POST["midwayLGA"]);
                        $midway_longitude = filter_var_array($_POST["midwayLongitude"]);
                        $midway_latitude = filter_var_array($_POST["midwayLatitude"]);

                        foreach($midway_state as $key => $value){
                            if(empty($value)){
                              echo 'You missed a state value for Midway State '.$key + 1;
                              exit();
                            }
                        }

                        $midway_state = implode(',', $midway_state);
                        $midway_lga = implode(',', $midway_lga);
                        $midway_longitude = implode(',', $midway_longitude);
                        $midway_latitude = implode(',', $midway_latitude);
                    }else{
                        $midway_state = null;
                        $midway_lga = null;
                        $midway_longitude = null;
                        $midway_latitude = null;
                    }

                    $array['project sector'] = $_SESSION['sector'];
                    $array['year_of_entry'] = date("Y");
                    $array['origin_longitude'] = $_POST['originLongitude'];
                    $array['origin_latitude'] = $_POST['originLatitude'];
                    $array['destination_longitude'] = $_POST['destinationLongitude'];
                    $array['destination_latitude'] = $_POST['destinationLatitude'];
                    $array['midway_points'] = $midway_points;
                    $array['midway_state'] = $midway_state;
                    $array['midway_lga'] = $midway_lga;
                    $array['midway_latitude'] = $midway_latitude;
                    $array['midway_longitude'] = $midway_longitude;
                    $array['approved'] = $_SESSION['designation'] != 'budgeting officer' ? '1' : '0';
                    // $array['date_approved'] = $_SESSION['designation'] != 'budgeting officer' ? date("Y-m-d") : null;
                    $array['added_by'] = $_SESSION['name'];
                    $array['added_by_designation'] = $_SESSION['designation'];
                    $array['date_added'] = date("Y-m-d");
                    
                    $array['metrics'] = '0';

                    echo $project->addProject($array);

                }else{
                    echo $emptyCheck;
                }
            break;
        }
    break;

    case isset($_POST['Construction_Type']):
        switch (true) {
            default:
                $project = new Project;
                $input = new Input;
                
                foreach ($_POST as $key => $value) {
                    isset($key) ? $key : '';
                }
                $array = $_POST;
               
                unset($array['Investment_Payback_Period_(in_years)']);//remove investment payback period has it is not required;
                unset($array['Number_of_jobs_created']);
                unset($array['Number_of_jobs_that_would_be_retained']);
                unset($array['project_name']);//remove the metrics id and add it later;
                unset($array['sector']);
                
                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true){
                    if(!empty($_POST['Investment_Payback_Period_(in_years)'])){
                        $array['Investment_Payback_Period_(in_years)'] = $_POST['Investment_Payback_Period_(in_years)'];
                    }else{
                        $array['Investment_Payback_Period_(in_years)'] = '0';
                    }

                    $array['Number_of_jobs_that_would_be_retained'] = $_POST['Number_of_jobs_that_would_be_retained'];
                    $array['Number_of_jobs_created'] = $_POST['Number_of_jobs_created'];

                    $table_prefix = $project->table_prefix($_POST['sector']);
                    
                    foreach($array as  $key => $value)
                    {
                        if (preg_match('/^[0-9,.]+$/', $value) === 1) {//check if the set of numbers has a comma
                            $array[$key] = str_replace(',', '', $value);
                        }
                    }

                    $sql = "INSERT INTO `".$table_prefix."_projects_metrics` SET ";
                    foreach ($array as $key => $value) {
                        $sql .=  "`".$key."` = '".$value."', ";
                    }
                    $sql = rtrim($sql, ', ');

                    $project->runInsertQuery($sql);

                    $update = "UPDATE `projects` SET `metrics` = '1' WHERE `id` = '".$_POST['project_id']."'";
                    $project->runInsertQuery($update);

                    $getmetricsId = "SELECT `id` FROM `".$table_prefix."_projects_metrics` WHERE `project_id` = '".$_POST['project_id']."' ORDER BY `id` DESC LIMIT 1";
                    $addedMetricsId = ($project->runSelectQuery($getmetricsId))[0]['id'];

                    $metricsData = $project->getMetrics($_POST['sector']);
                    foreach ($metricsData as $key => $metrics){
                        $metrics_data = json_decode($metrics['metrics_data'], TRUE);
                    }

                    foreach($metrics_data as $key => $val){
                        foreach($val as $key => $metrics){
                            foreach($metrics as $key => $label){
                                foreach ($array as $formDataKey => $value) {
                                    $newDataKey = str_replace('_', ' ', $formDataKey); //remove the underscore from the form-input names as in the $array
                                    if($newDataKey === $label['label']){ //check if form-input and metrics label are the same
                                        if($label['element'] == 'select')
                                        {
                                            $array[$formDataKey] = $label['options'][$value];
                                        }else
                                        {
                                            $sql = "SELECT `".$table_prefix."_projects_metrics`.`id`, `".$table_prefix."_projects_metrics`.`".$formDataKey."` FROM `".$table_prefix."_projects_metrics` JOIN `projects` WHERE `".$table_prefix."_projects_metrics`.`project_id` = `projects`.`id` AND `projects`.`suspended` != '1' ORDER BY `".$formDataKey."` DESC";
                                            $metrics_result = $project->runSelectQuery($sql);
                                            
                                            foreach ($metrics_result as $metrics_resultKey => $metrics_resultData)
                                            {
                                                if($_POST['metrics_id'] == $metrics_resultData['id'])
                                                {
                                                    $compared = $project->getCompared($metrics_result, $formDataKey, $value);

                                                    if($formDataKey == 'Investment_Payback_Period_(in_years)' && $metrics_resultData[$formDataKey] == '0'){
                                                        $array[$formDataKey] = $label['data-score']['No-Payback'];
                                                    }else
                                                    {
                                                        if($compared == 'Low')
                                                        {
                                                            $array[$formDataKey] = $label['data-score'][$compared];
                                                        }elseif($compared == 'Medium')
                                                        {
                                                            $array[$formDataKey] = $label['data-score'][$compared];
                                                        }elseif($compared == 'High')
                                                        {
                                                            $array[$formDataKey] = $label['data-score'][$compared];
                                                        }
                                                    }
                                                }else{
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

                    unset($array['project_id']);
                    $total_score = array_sum($array);
                    $array['metrics_id'] = $addedMetricsId;

                    $sql = "INSERT INTO `".$table_prefix."_projects_scores` SET ";
                    foreach ($array as $key => $value) {
                        $sql .=  "`".$key."` = '".$value."', ";
                    }
                    $sql = rtrim($sql, ', ');
                    $project->runInsertQuery($sql);

                    $update = "UPDATE `projects` SET `score` = '".$total_score."' WHERE `id` = '".$_POST['project_id']."'";
                    $project->runInsertQuery($update);

                    echo 'success!=/projects/view/'.$_POST['sector'].'/'.$_POST['project_name'].'/'.$_POST['project_id'];

                }else{
                    echo $emptyCheck;
                }
            break;
        }
    break;
}
