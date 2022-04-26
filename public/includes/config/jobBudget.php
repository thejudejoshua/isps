<?php

require_once 'config.php';

$project = new Budget;


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
                $project = new Budget;

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

    case isset($_POST['budget_year']):
        switch (true)
        {
            default:
                $array = $_POST;

                $input = new Input;
                $project = new Budget;
                
                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true)
                {
                    foreach($array as  $key => $value)
                    {
                        if (preg_match('/^[0-9,.]+$/', $value) === 1) {//check if the set of numbers has a comma
                            $array[$key] = str_replace(',', '', $value);
                        }
                    }
                    $sector_id = $project->getSectorData($_SESSION['sector'])[0]['id'];
                    $oldBudgetData = $project->getBudget($_SESSION['sector'], $array['budget_year']);
                    
                    if(!empty($oldBudgetData))
                    {

                        $executionList = $project->getExecutionList($_SESSION['sector']);
                        $total_funding = 0;
                        $total_new_funding = 0;
                        foreach ($executionList as $oldProjectBudget) {
                            $total_funding += $oldProjectBudget['funding'];
                        }
                        foreach ($oldBudgetData as $oldbudgetvalue) {
                            $oldratio = number_format((float)($oldbudgetvalue['amount'] - $oldbudgetvalue['funds_available'])/$oldbudgetvalue['amount'], 2, '.', '');//get the ratio to use and calculate how much was distributed between the projects previously
                        }

                        $distribution_amount = $oldratio * $array['budget_amount']; //get the distribution amount for the new budget
                        
                        foreach ($executionList as $oldProjectBudget) {
                            $new_funding = number_format((float)($oldProjectBudget['funding']/$total_funding) * $distribution_amount, 2, '.', '');
                            if ($new_funding < $oldProjectBudget['cost']) {
                                $new_shortfall = 0;
                            } else {
                                $new_shortfall = number_format((float)($new_funding - $oldProjectBudget['cost']), 2, '.', '');
                            }

                            $query = "UPDATE `execution_list` SET `funding` = '".$new_funding."', `shortfall` = '".$new_shortfall."' WHERE `project_id` = '".$oldProjectBudget['project_id']."'";
                            $run = $project->runInsertQuery($query);

                            $total_new_funding += number_format((float)$new_funding, 2, '.', '');
                        }

                        $budget_left = number_format((float)($array['budget_amount'] - $total_new_funding), 2, '.', '');                        

                        $query = "UPDATE `budget` SET `amount` = '".$array['budget_amount']."', `funds_available` = '".$budget_left."' WHERE `sector` = '".$sector_id."' AND `year` = '".$array['budget_year']."'";
                        $catch = 'updated';
                    }else
                    {
                        $query = "INSERT INTO `budget`(`sector`, `year`, `amount`, `funds_available`) VALUES ('".$sector_id."', '".$array['budget_year']."', '".$array['budget_amount']."', '".$array['budget_amount']."')";
                        $catch = 'created';
                    }

                    $run = $project->runInsertQuery($query);
                    if($run == true)
                    {
                        echo "success!=Your specified annual budget was ".$catch." successfully!";
                    }else
                    {
                        echo "error=".$run;
                    }

                }else{
                    echo $emptyCheck;
                }
                
            break;
        }
    break;

    case isset($_POST['funding']):
        switch (true)
        {
            default:
                $array = $_POST;

                $input = new Input;
                $project = new Budget;
                
                $emptyCheck = $input->caseEmpty($array);
                if($emptyCheck === true)
                {
                    foreach($array as  $key => $value)
                    {
                        if(is_array($value))
                        {
                            foreach($value as $newkey => $newvalue)
                            {
                                if (preg_match('/^[0-9,.]+$/', $newvalue) === 1) {//check if the set of numbers has a comma
                                    $value[$newkey] = str_replace(',', '', $newvalue);
                                }
                            }
                            $array[$key] = $value;
                        }else
                        {
                            if (preg_match('/^[0-9,.]+$/', $value) === 1) {//check if the set of numbers has a comma
                                $array[$key] = str_replace(',', '', $value);
                            }
                        }
                    }

                    $budget_left = array_pop($array);
                    $budget_id = array_pop($array);
                    $full_budget = array_shift($array);

                    $array = array_values($array);//change array keys to numeric
                    
                    function transpose($array) {//regroup and reorder the array to same group
                        array_unshift($array, null);
                        return call_user_func_array('array_map', $array);
                    }

                    $array = transpose($array);

                    foreach ($array as $key => $value) {
                        $query = "UPDATE `execution_list` SET `funding` = '".$value[0]."', `shortfall` = '".$value[1]."' WHERE `project_id` = '".$value[2]."'";
                        $run = $project->runInsertQuery($query);
                    }

                    $update = "UPDATE `budget` SET `funds_available` = '".$budget_left."' WHERE `id` = '".$budget_id."'";
                    $run = $project->runInsertQuery($update);

                    echo "success!=Your distributed project budget was updated successfully!";

                }else{
                    echo $emptyCheck;
                }
                
            break;
        }
    break;
}