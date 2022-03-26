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
                    'project sector'=>isset($_POST['projectSector']) ? $_POST['projectSector'] : '',
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
                    $array['approved'] = '0';
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
}
