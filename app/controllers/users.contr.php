<?php

class Users extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer'){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{

            $user = $this->model('User');
            $usersList = $user->getAllUsers();

            $this->views('users/index', [
                'usersList' => $usersList
            ]);
        }
    }

    public function add()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer'){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            $this->views('users/add/index', [
    
            ]);
        }
    }

    public function view()
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer'){

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
                    $this->views('users/view/index', [
                        'userDataList' => $userDataList
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