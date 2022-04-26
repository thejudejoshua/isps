<?php

class Sector extends Projects
{
    public function index()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer')
        {

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else
        {            
            $project = $this->model('Budget');
            
            $table_prefix = $project->table_prefix($_SESSION['sector']);

            $allProjectsLists = $project->getAllSectorProjectSummary($_SESSION['sector'], $table_prefix);
            $executionList = $project->getExecutionList($_SESSION['sector']);

            $project_scores = $this->rank_projects($_SESSION['sector']);

            $metricsData = $project->getMetrics($_SESSION['sector']);
            
            $this->views('sector/index', [
                'projectsList' => $allProjectsLists,
                'executionList' => $executionList,
                'project_scores' => $project_scores,
                'metricsData' => $metricsData,
            ]);
        }
    }


    public function jobs()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer')
        {

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);

        }else
        {

            $project = $this->model('Budget');
            
            if($_SESSION['designation'] == 'admin'){
                $jobsList = $project->getAllJobsBudget();
                $sectorList = $project->getSectorList();
            }else{
                $jobsList = $project->getJobsBudget($_SESSION['sector']);
                $sectorList = $_SESSION['sector'];
            }

            $this->views('sector/jobs/index', [
                'jobsList' => $jobsList,
                'sectorList' => $sectorList
            ]);
        }
    }

    public function budget()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer')
        {

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else
        {
            $project = $this->model('Budget');
            $allBudget = $project->getBudget($_SESSION['sector'], date("Y"));
            $pastBudget = $project->getPastBudget($_SESSION['sector'], date("Y"));
            
            $executionList = $project->getExecutionList($_SESSION['sector']);

            $this->views('sector/budget/index', [
                'allBudget' => $allBudget,
                'pastBudget' => $pastBudget,
                'executionList' => $executionList,
            ]);
        }
    }


}