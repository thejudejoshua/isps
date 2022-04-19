<?php

class Jobs extends Controller
{

    public function index()
    {
        echo 'this is the index';

    }

    public function add()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer')
        {

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $project = $this->model('Project');

            $jobsList = $project->getAllJobsBudget();

            $sectorList = $project->getSectorList();

            $this->views('budget/jobs/add/index', [
                'jobsList' => $jobsList,
                'sectorList' => $sectorList
            ]);
        }
    }

}