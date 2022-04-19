<?php

class Edit extends Projects
{
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
                $project = $this->model('Project');

                $input->sanitizeInput($array);
                $id = $array[0];
                $sector = $array[1];

                $projectData = $project->getProjectData($id);//get the project data
                
                $metricsData = $project->getMetrics($sector);
                foreach ($metricsData as $key => $metrics){
                    $metricsData = json_decode($metrics['metrics_data'], TRUE);
                }
                
                $jobs = $this->get_jobs($sector);//get the job total for this sector
                
                $project_jobs_created = round(($projectData[0]['cost'] * $jobs[0]['total'])/$jobs[0]['budget_per_total_jobs']);
                
                $table_prefix = $project->table_prefix($_SESSION['sector']);
                
                $projectMetricsData = $project->getProjectMetrics($table_prefix, $id);
                $projectMetricsScore = $project->getProjectMetricsScores($table_prefix, $id);

                if(is_array($metricsData))
                {
                    $this->views('/projects/edit/metrics/index', [
                        'projectData' => $projectData,
                        'metricsData' => $metricsData,
                        'Number of jobs created' => $project_jobs_created,
                        'Number of jobs that would be retained' => $project_jobs_created/2,
                        'Project cost (amount to be spent by government)' => $projectData[0]['cost'],
                        'projectMetricsData' => $projectMetricsData,
                        'projectMetricsScore' => $projectMetricsScore,
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