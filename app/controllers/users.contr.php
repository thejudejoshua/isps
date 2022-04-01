<?php

class Users extends Controller
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

            $user = $this->model('User');
            if($_SESSION['designation'] == 'admin'){
                $usersList = $user->getAllUsers();
            }else{
                $usersList = $user->getAllSectorUsers($_SESSION['sector']);
            }

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

    public function view($designation = '', $id = '')
    {
        if(!isset($_SESSION['logged']) || $_SESSION['designation'] == 'budgeting officer'){

            $redirect = $this->model('Redirect');
            $dashboard = '/dashboard';
            $redirect->redirectTo($dashboard);
            
        }else{
            if(isset($designation) && isset($id))
            {
                if($id != '' && $designation != ''){

                    $array = [(INT)$id, $designation];
    
                    $input = $this->model('Input');
                    $user = $this->model('User');
    
                    $input->sanitizeInput($array);
                    $id = $array[0];
                    $role = $array[1];
    
                    $userDataList = $user->getUserData($id, $role);
                    
                    if(is_array($userDataList))
                    {
                        $name = "{$userDataList[0]['added_by']}";
    
                        $query = "SELECT `id` FROM `".$userDataList[0]['added_by_designation']."` WHERE `firstName` = '".explode(' ', $name)[0]."' AND `lastName` = '".explode(' ', $name)[1]."'";
                        
                        $db_model = $this->model('Db');
                        $added_by_data = $db_model->runSelectQuery($query);
    
                        $this->views('users/view/index', [
                            'userDataList' => $userDataList,
                            'added_by_id' => isset($added_by_data[0]['id']) ? $added_by_data[0]['id'] : ''
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