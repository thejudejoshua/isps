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
            $allProjects  = $project->getAllUserSectorProjects($_SESSION['sector']);

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

    public function view($sector = '', $projectname = '', $id = '')
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            if(isset($id) && isset($sector) && isset($projectname))
            {
                
                $array = [$id, $sector];
                
                $input = $this->model('Input');
                $user = $this->model('User');
                $project = $this->model('Project');
                
                $input->sanitizeInput($array);
                $id = $array[0];
                $sector = $array[1];

                $projectData = $project->getProjectData($id);
                $metricsData = $project->getMetrics($sector);
                
                if($projectData[0]['sector'] == 'Railway Construction'){
                    $table_prefix = 'railway';
                }else if($array['sector'] == 'Highway Construction'){
                    $table_prefix = 'highway';
                }
                
                $projectMetricsData = $project->getProjectMetrics($table_prefix, $id);
                $projectMetricsScore = $project->getProjectMetricsScores($table_prefix, $id);

                $this->views('projects/view/index', [
                    'project' => $projectname,
                    'sector' => $sector,
                    'id' => $id,
                    'metricsData' => $metricsData,
                    'projectData' => $projectData,
                    'projectMetricsData' => $projectMetricsData,
                    'projectMetricsScore' => $projectMetricsScore,
                ]);

            }else{
                $error = new Errors;
                $error->not_found();//404 error
            }

        }   
    }

    public function approve()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $project = $this->model('Project');
            $allProjects  = $project->getUnapprovedProjects($_SESSION['sector']);

            $this->views('projects/approve/index', [
                'projectsList' => $allProjects
            ]);
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