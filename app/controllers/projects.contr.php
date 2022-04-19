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
            $allProjects  = $project->getAllActiveUserSectorProjects($_SESSION['sector']);

            $project_scores = $this->rank_projects($_SESSION['sector']);
            
            $this->views('projects/index', [
                'emptyMetrics' => $emptyMetrics,
                'projectsList' => $allProjects,
                'project_scores' => $project_scores
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
                $project = $this->model('Project');
                
                $input->sanitizeInput($array);
                $id = $array[0];
                $sector = $array[1];

                $projectData = $project->getProjectData($id);
                $metricsData = $project->getMetrics($sector);
                foreach ($metricsData as $key => $metrics){
                    $metricsData = json_decode($metrics['metrics_data'], TRUE);
                }
                
                $table_prefix = $project->table_prefix($_SESSION['sector']);

                $projectMetricsData = $project->getProjectMetrics($table_prefix, $id);
                $projectMetricsScore = $project->getProjectMetricsScores($table_prefix, $id);

                $totalMetricsScore = $this->find_metrics_total_score($metricsData, $projectMetricsData);

                $project_scores = $this->rank_projects($sector);
                if(is_array($project_scores))
                {
                    foreach ($project_scores as $key => $value) {
                        $project_rank_overall = count($project_scores);
                        if($id == $value['id'])
                        {
                            $project_rank = array_search($value, $project_scores) + 1;
                        }else{
                            $project_rank = '';
                        }
                    }
                }else{
                    $project_rank = '';
                    $project_rank_overall = '';
                }

                $this->views('projects/view/index', [
                    'project' => $projectname,
                    'sector' => $sector,
                    'id' => $id,
                    'metricsData' => $metricsData,
                    'projectData' => $projectData,
                    'projectMetricsData' => $projectMetricsData,
                    'projectMetricsScore' => $projectMetricsScore,
                    'totalMetricsScore' => $totalMetricsScore,
                    'project_rank' => $project_rank,
                    'project_rank_overall' => $project_rank_overall
                ]);
            }else{
                $error = new Errors;
                $error->not_found();//404 error
            }

        }   
    }

    public function edit($sector = '', $projectname = '', $id = '')
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
                // $metricsData = $project->getMetrics($sector);
                // foreach ($metricsData as $key => $metrics){
                //     $metricsData = json_decode($metrics['metrics_data'], TRUE);
                // }
                
                // $table_prefix = $project->table_prefix($_SESSION['sector']);

                // $projectMetricsData = $project->getProjectMetrics($table_prefix, $id);
                // $projectMetricsScore = $project->getProjectMetricsScores($table_prefix, $id);

                // $totalMetricsScore = $this->find_metrics_total_score($metricsData, $projectMetricsData);

                // $project_scores = $this->rank_projects($sector);
                // if(is_array($project_scores))
                // {
                //     foreach ($project_scores as $key => $value) {
                //         $project_rank_overall = count($project_scores);
                //         if($id == $value['id'])
                //         {
                //             $project_rank = array_search($value, $project_scores) + 1;
                //         }else{
                //             $project_rank = '';
                //         }
                //     }
                // }else{
                //     $project_rank = '';
                //     $project_rank_overall = '';
                // }

                $this->views('projects/edit/index', [
                    'project' => $projectname,
                    'sector' => $sector,
                    'id' => $id,
                    // 'metricsData' => $metricsData,
                    'projectData' => $projectData,
                    // 'projectMetricsData' => $projectMetricsData,
                    // 'projectMetricsScore' => $projectMetricsScore,
                    // 'totalMetricsScore' => $totalMetricsScore,
                    // 'project_rank' => $project_rank,
                    // 'project_rank_overall' => $project_rank_overall
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

            $project_scores = $this->rank_projects($_SESSION['sector']);

            $this->views('projects/approve/index', [
                'projectsList' => $allProjects,
                'project_scores' => $project_scores
            ]);
        }
    }

    public function unapproved()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $project = $this->model('Project');
            $allProjects  = $project->getUnapprovedProjects($_SESSION['sector']);
            
            $project_scores = $this->rank_projects($_SESSION['sector']);

            $this->views('projects/approve/index', [
                'projectsList' => $allProjects,
                'project_scores' => $project_scores
            ]);
        }
    }

    public function suspended()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $project = $this->model('Project');
            $allProjects  = $project->getSuspendedProjects($_SESSION['sector']);

            $project_scores = $this->rank_projects($_SESSION['sector']);

            $this->views('projects/suspended/index', [
                'projectsList' => $allProjects,
                'project_scores' => $project_scores
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

                $projectData = $project->getProjectData($id);//get the project data
                
                if($projectData[0]['metrics'] == '0'){
                    $metricsData = $project->getMetrics($sector);
    
                    $jobs = $this->get_jobs($sector);//get the job total for this sector
    
                    $project_jobs_created = round(($projectData[0]['cost'] * $jobs[0]['total'])/$jobs[0]['budget_per_total_jobs']);

                    
                    if(is_array($metricsData))
                    {
                        $this->views('projects/metrics/index', [
                            'project' => $projectname,
                            'sector' => $sector,
                            'id' => $id,
                            'metricsData' => $metricsData,
                            'Number of jobs created' => $project_jobs_created,
                            'Number of jobs that would be retained' => $project_jobs_created/2,
                            'Project cost (amount to be spent by government)' => $projectData[0]['cost']
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

    public function compare()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $project = $this->model('Project');

            $allProjects  = $project->getAllActiveUserSectorProjects($_SESSION['sector']);
            
            $project_scores = $this->rank_projects($_SESSION['sector']);

            $this->views('projects/compare/index', [
                'projectsList' => $allProjects,
                'project_scores' => $project_scores
            ]);
        }
    }
    
    protected function find_metrics_total_score($metricsData, $projectMetricsData)
    {
        $totalMetricsScore = 0;
        foreach($metricsData as $key => $val){
            foreach($val as $key => $metrics){
                foreach($metrics as $key => $label){
                    foreach ($projectMetricsData[0] as $formDataKey => $value) {
                        $newDataKey = str_replace('_', ' ', $formDataKey); //remove the underscore from the form-input names as in the $array
                        if($newDataKey === $label['label']){
                            if($label['element'] == 'select')
                            {
                                $totalMetricsScore += max($label['options']);
                            }else
                            {
                                $totalMetricsScore += max($label['data-score']);
                            }
                        }
                    }
                }
            }
        }
        return $totalMetricsScore;
    }

    protected function rank_projects($sector)
    {
        $db_model = $this->model('Db');
        $sql = "SELECT `id`, `score` FROM `projects` WHERE `sector` = '".$sector."' AND `suspended` != '1' AND `metrics` = '1' ORDER BY `score` DESC";
        return $db_model->runSelectQuery($sql);
    }

    protected function get_jobs($sector)
    {
        $db_model = $this->model('Db');
        $sql = "SELECT `jobs`.`total`,  `jobs`.`budget_per_total_jobs` FROM `sectors` JOIN `jobs` WHERE `sector_name` = '".$sector."' AND `jobs`.`sector_id` = `sectors`.`id`";
        return $db_model->runSelectQuery($sql);
    }

}