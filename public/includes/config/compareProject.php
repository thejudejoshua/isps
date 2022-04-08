<?php

require_once 'config.php';

$project = new Project();

switch($_POST){
    case isset($_POST['project']):
        switch (true) {
            default:
                $table_prefix = $project->table_prefix($_SESSION['sector']);

                $sql = "SELECT `projects`.`score`, `".$table_prefix."_projects_metrics`.`Private/Public/Local_Participation`,`".$table_prefix."_projects_metrics`.`Population_to_be_served`,`".$table_prefix."_projects_metrics`.`Amount_of_Co2_Emmissions_from_the_project`,`".$table_prefix."_projects_metrics`.`Number_of_jobs_created` FROM `projects` JOIN `".$table_prefix."_projects_metrics` WHERE `projects`.`name` = '".$_POST['project']."' AND `".$table_prefix."_projects_metrics`.`project_id` = `projects`.`id`";
                
                $comparisons = $project->runSelectQuery($sql);

                $sql = "SELECT `name`, `score` FROM `projects` WHERE `sector` = '".$_SESSION['sector']."' AND `suspended` != '1' AND `metrics` = '1' ORDER BY `score` DESC";
                $rankingsList = $project->runSelectQuery($sql);
                if(is_array($rankingsList))
                {
                    foreach ($rankingsList as $key => $value) {
                        $project_rank_overall = count($rankingsList);
                        if($_POST['project'] == $value['name'])
                        {
                            $project_rank = array_search($value, $rankingsList) + 1;
                        }
                    }
                }else{
                    $project_rank = '';
                    $project_rank_overall = '';
                }
        
            
                echo 'success!='.$comparisons[0]['score'].'-'.$project_rank.'/'.$project_rank_overall.'-'.$comparisons[0]['Private/Public/Local_Participation'].'-'.$comparisons[0]['Population_to_be_served'].'-'.$comparisons[0]['Amount_of_Co2_Emmissions_from_the_project'].'-'.$comparisons[0]['Number_of_jobs_created'];
                
            break;
        }
    break;
}
