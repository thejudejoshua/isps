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
            // $allProjects  = $project->getAllProjects($_SESSION['sector']);
            $allProjects  = $project->getAllProjects();

            $this->views('projects/index', [
                'emptyMetrics' => $emptyMetrics,
                'projectsList' => $allProjects
            ]);
        }
    }

    public function add()
    {
        if(!isset($_SESSION['logged']))
        {
            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);   
        }else{
            $project = $this->model('Project');
            $sectorList = $project->getSectorList();
            $this->views('projects/add/index', [
                'sectorList' => $sectorList
            ]);
        }
    }

    public function view()
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
                    $this->views('projects/view/index', [
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
    
    public function metrics($projectname = '', $id = '', $sector = '')
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
                $project = $this->model('Project');
                
                $input->sanitizeInput($array);
                $id = $array[0];
                $sector = $array[1];

                //perform a check for if this project metrics has already been edited
                $projectData = $project->getProjectData($id);
                if($projectData[0]['metrics'] == '0'){
                    $metricsData = $project->getMetrics($sector);
                    
                    if(is_array($metricsData))
                    {
                        $this->views('projects/metrics/index', [
                            'project' => $projectname,
                            'sector' => $sector,
                            'id' => $id,
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

            }else{
                $error = new Errors;
                $error->restricted();//403 error
            }
        }   
    }
}