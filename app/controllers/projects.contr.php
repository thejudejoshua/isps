<?php

class Projects extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $project = $this->model('Project');
            $emptyMetrics = $project->findEmptyMetrics($_SESSION['name']);
            $allProjects  = $project->getAllProjects();

            $this->view('projects/index', [
                'emptyMetrics' => $emptyMetrics,
                'projectsList' => $allProjects
            ]);
        }
    }

    public function add_project()
    {
        if(!isset($_SESSION['logged']))
        {
            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);   
        }else{
            $project = $this->model('Project');
            $sectorList = $project->getSectorList();
            $this->view('projects/add_project/index', [
                'sectorList' => $sectorList
            ]);
        }
    }

    public function view_project()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            if(isset($_GET['id']) && isset($_GET['role']))
            {

                $array = [(INT)$_GET['id'], $_GET['role']];

                $input = $this->model('Input');
                $user = $this->model('User');

                $input->sanitizeInput($array);
                $id = $array[0];
                $role = $array[1];

                $userDataList = $user->getUserData($id, $role);
                
                if(is_array($userDataList))
                {
                    $this->view('projects/view/index', [
                        'userDataList' => $userDataList
                    ]);

                }else{
                    $this->index();
                }
            }else{
                $this->index();
            }

        }   
    }
    
    public function add_metrics($projectname = '', $id = '', $sector = '')
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            if(isset($id) && isset($sector))
            {
                $array = [$id, $sector];

                $input = $this->model('Input');
                $user = $this->model('User');

                $input->sanitizeInput($array);
                $id = $array[0];
                $sector = $array[1];

                $project = $this->model('Project');
                $metricsData = $project->getMetrics($sector);
                
                if(is_array($metricsData))
                {
                    $this->view('projects/add_metrics/index', [
                        'project' => $projectname,
                        'sector' => $sector,
                        'metricsData' => $metricsData,
                    ]);
                }else{
                    $error = new Errors;
                    $error->restricted();//403 error
                }
            }else{
                $error = new Errors;
                $error->restricted();//403 error
            }
        }   
    }
}