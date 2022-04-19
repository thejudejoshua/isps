<?php

require_once 'config.php';

$project = new Project();

switch($_POST){
    case isset($_POST['project_id']):
        switch (true) {
            default:
               if(!isset($_POST['list_type']) || $_POST['list_type'] == '')
               {
                   echo "error=Select if this project belongs to Execution or Priority list";
               }else
               {
                    if($_POST['list_type'] == 'priority-list')
                    {
                        $project->addProjectPriority($_POST['project_id']);
                    }else
                    {
                        $project->addProjectExecution($_POST['project_id']);
                    }

                    $date_approved = date("Y-m-d");

                    echo $project->approveProject($_POST['project_id'], $_SESSION['name'], $_SESSION['designation'], $date_approved);
               }
            break;
        }
    break;
}
