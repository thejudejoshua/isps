<?php

    require_once 'config.php';

    $project = new Project();

    $sData = "%{$_POST["keyword"]}%";
    $searchData = $project->searchProject($_SESSION['sector'], $sData);
    $count = 10;

    $sql = "SELECT `id`, `score` FROM `projects` WHERE `sector` = '".$_SESSION['sector']."' AND `suspended` != '1' AND `metrics` = '1' ORDER BY `score` DESC";
    $project_scores = $project->runSelectQuery($sql);

    if($searchData != []){
        echo'
            <table>
                <thead>
                    <tr>
                        <th><h4>Project Name</h4></th>
                        <th><h4>Project Score</h4></th>
                        <th><h4>Project Rank</h4></th>
                        <th><h4>Added by</h4></th>
                        <th><h4>Date Added</h4></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            ';
            foreach ($searchData as $key => $project) {
                echo'
                    <tr>
                        <td><h4>'.$project['name'].'</h4></td>
                        <td><p class="p5">'.$project['score'].'</p></td>
                        <td><p class="p5">';
                        foreach ($project_scores as $key => $value) {
                            if($project['id'] == $value['id'])
                            {
                                echo $project_rank = array_search($value, $project_scores) + 1;
                            }
                        };
                        echo '</p></td>
                        <td><p class="p5">'.$project['added_by'].'</p></td>
                        <td><p class="p5">'.date('d M, Y', strtotime( $project['date_added'])).'</p></td>
                        <td>
                            <a href="/projects/view/'.$project['sector'].'/'.$project['name'].'/'.$project['id'].'" class="action view-project">View</a>
                        </td>
                    </tr>
                ';
            };
            echo '
                </tbody>
            </table>
            ';
    }else{
        echo '                    
            <div class="empty full-width text-align-center d-flex flex-column justify-content-center">
                <p class="p4 notice"><span><i class="las la-folder-open"></i></span><br/>No active projects match that parameter. Try again</p>
            </div>
        ';
    }