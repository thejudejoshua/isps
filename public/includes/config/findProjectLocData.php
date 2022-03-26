<?php

require_once 'config.php';

$project = new Project;


if(isset($_GET['check']))
{
    if($_GET['check'] == 'lga')
    {
        $state = "{$_POST["keyword"]}";
        $lgaList = $project->getLGA($state);
        if(is_array($lgaList)){
            echo '<option value="" selected hidden disabled>Select LGA</option>';
            foreach($lgaList as $key => $lga)
            {
                $lga = array_filter(array_slice($lga, 4));
                foreach($lga as $local_government)
                {
                    echo '
                        <option value="'.$local_government.'">'.$local_government.'</option>
                    ';
                }
    
            }
        }else{
            echo $lgaList;
        }
    }
    else
    {
        $state = "{$_POST["keyword"]}";
        $latList = $project->getLngLat($state);
        if(is_array($latList)){
            foreach($latList as $key => $lat)
            {
                $latitude = $lat['lat'];
                $longitude = $lat['lng'];
                
            }
        }

        echo $latitude. ':'. $longitude;
    }
}else{
    $state = "%{$_POST["keyword"]}%";
    $statesList = $project->getState($state);
    if(is_array($statesList)){
        echo'
            <ul>';
                foreach ($statesList as $value) {
                    echo '
                        <li>'.$value['state'].'</li>
                    ';
                }
            echo'
            </ul>
        ';
        
    }else{
        echo $statesList;
    }
}

