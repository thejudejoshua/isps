<?php

class Budget extends Controller
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

            $project = $this->model('Project');
            
            if($_SESSION['designation'] == 'admin'){
                $jobsList = $project->getAllJobsBudget();
                $sectorList = $project->getSectorList();
            }else{
                $jobsList = $project->getJobsBudget($_SESSION['sector']);
                $sectorList = $_SESSION['sector'];
            }


            $this->views('budget/index', [
                'jobsList' => $jobsList,
                'sectorList' => $sectorList
            ]);
        }
    }

}