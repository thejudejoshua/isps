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

            $this->view('projects/index', [
                'usersList' => []
            ]);
        }
    }

    public function add_project()
    {
        if(!isset($_SESSION['logged'])){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            $this->view('projects/add_project/index', [
    
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
    
}