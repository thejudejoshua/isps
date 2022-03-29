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
                    'project sector'=> $_POST['projectSector'],
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
               
                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true){
                    if($array['sector'] == 'Railway Construction'){
                        $table_prefix = 'railway';
                    }else if($array['sector'] == 'Highway Construction'){
                        $table_prefix = 'highway';
                    }
                    
                    foreach($array as  $key => $value)
                    {
                        $array[$key] = str_replace(',', '', $value);
                    }
                    $function = 'add'.$table_prefix.'ProjectMetrics';
                    $addedMetricsId = $project->$function($array);

                    $metricsData = $project->getMetrics($array['sector']);
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
                                            $input = str_replace(',', '', $value);//remove all the commas from input formatting
                                            $sql = "SELECT `id`, `".$formDataKey."` FROM `".$table_prefix."_projects_metrics` ORDER BY `".$formDataKey."` DESC";
                                            $result = $project->runQuery($sql);
                                            foreach ($result as $resultKey => $resultData)
                                            {
                                                if($addedMetricsId == $resultData['id'])
                                                {
                                                    $matches = array_search($resultData, $result) + 1;
                                                    if($matches < ceil(count($result)/2))
                                                    {
                                                        $array[$formDataKey] = $label['data-score']['High'];
                                                    }elseif($matches > ceil(count($result)/2))
                                                    {
                                                        $array[$formDataKey] = $label['data-score']['Low'];
                                                    }else
                                                    {
                                                        $array[$formDataKey] = $label['data-score']['Medium'];
                                                    }
                                                }else
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
                                                    $project->runQuery($sql);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $score_array = $array;
                    array_pop($score_array);
                    array_pop($score_array);
                    
                    $total_score = array_sum($score_array);
                    $array['total_score'] = $total_score;
                    $array['metrics_id'] = $addedMetricsId;

                    $function = 'add'.$table_prefix.'ProjectScores';
                    echo $project->$function($array);

                }else{
                    echo $emptyCheck;
                }
            break;
        }
    break;
}
