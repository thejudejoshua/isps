<?php

class Dashboard extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $login = '/login';
            $redirect->redirectTo($login);
            
        }else{

            $project = $this->model('Project');
            
            $activeProjects = count($project->getAllActiveUserSectorProjects($_SESSION['sector']));
            $suspendedProjects  = count($project->getSuspendedProjects($_SESSION['sector']));
            $allNewProjects  = count($project->getAllNewSectorProjects($_SESSION['sector']));

            $getChartRegions = $project->getAllRegionProjects($_SESSION['sector']);

            $this->views('dashboard/index', [
                'activeProjects' => $activeProjects,
                'suspendedProjects' => $suspendedProjects,
                'allNewProjects' => $allNewProjects,
                'getChartRegions' => $getChartRegions
            ]);
        }
    }
    
}