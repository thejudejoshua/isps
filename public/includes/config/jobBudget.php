<?php

require_once 'config.php';

$project = new Project;


switch($_POST){
    case isset($_POST['sector']):
        switch (true) {
            default:
                $sector = "{$_POST["sector"]}";
                $jobsList = $project->getJobsBudget($sector);
                if(is_array($jobsList) && !empty($jobsList))
                {
                    $x = 0;
                    foreach ($jobsList as $key => $jobs)
                    {
                        $x++;
                        $return_data = 'success!=<form id="jobFormEdit">
                            <fieldset>
                                <legend>'.$sector.'</legend>
                        ';
                        array_shift($jobs);
                        array_shift($jobs);
                        foreach ($jobs as $table_header => $job)
                        {
                            is_numeric($job) ? number_format($job, '0', '.', ',') : $job;
                            $return_data .= 
                            '
                                <div class="form-group align-items-center">
                                    <div class="full-width">
                                        <label class="form-label" id="'.$table_header.'">'.$table_header.'</label>
                                        <input type="text" name="'.$table_header.'" class="form-control number-input '.$table_header.'" id="'.$table_header.'" readonly value="'.number_format($job,'0','.',',').'"/>
                                    </div>
                                </div>
                            ';
                        }
                        $return_data .= 
                        '
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" value="'.$sector.'" name="job-sector" class="job-sector">
                                        <button class="btn edit-jobs" id="edit-jobs">Edit data</button>
                                    </div>
                                </fieldset>
                            </form>
                        ';

                        echo $return_data;
                    }
                }else{
                    echo'error=We could not get the budget for your selected sector. Try another sector or add a new budget for this sector.';
                }
            break;
        }
    break;

    case isset($_POST['direct']):
        switch (true) {
            default:
                $array = $_POST;

                $input = new Input;
                $project = new Project;

                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true){
                    unset($array['job-sector']);
                    $array = $input->sanitizeInput($array);

                    $insert = '';
                    foreach ($array as $key => $value) {
                        $array[$key] = str_replace(',', '', $value);
                        $insert .= "UPDATE `jobs` JOIN `sectors` SET `".$key."` = '".$array[$key]."' WHERE `sectors`.`id` = `jobs`.`sector_id` AND `sectors`.`sector_name` = '".$_POST['job-sector']."';";
                    }
                    
                    $updateJobs = $project->runInsertQuery($insert);

                    if($updateJobs == true)
                    {
                        $table_prefix = $project->table_prefix($_POST['job-sector']);//get the table prefix too performm a search 

                        $allProjects = $project->getAllSectorProjects($_POST['job-sector']);

                        $update = '';
                        foreach ($allProjects as $projects => $projectArray)
                        {
                            $cost = $projectArray['cost'];
                            $Number_of_jobs_created = round(($cost * $array['total'])/$array['budget_per_total_jobs']);
                            $Number_of_jobs_that_would_be_retained = $Number_of_jobs_created/2;

                            $metrics['Number_of_jobs_that_would_be_retained'] = $Number_of_jobs_that_would_be_retained;
                            $metrics['Number_of_jobs_created'] = $Number_of_jobs_created;

                            foreach ($metrics as $key => $value)
                            {
                                $update .= "UPDATE `".$table_prefix."_projects_metrics` SET `".$key."` = '".$value."' WHERE `".$table_prefix."_projects_metrics`.`id` = '".$projectArray['cost']."';";
                            }
                        }
                        $updateJobsMetrics = $project->runInsertQuery($update);
                        if($updateJobsMetrics == true)
                        {
                            echo "success!=The data was updated successfully!";
                        }
                    }
                }else{
                    echo $emptyCheck;
                }
                
            break;
        }
    break;
}