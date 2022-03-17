<?php
    
    class Controller{

        protected $model = '';

        public function __construct()
        {
            $session = $this->model('Session');
            $session->startSession();
        }

        protected function model($model){
            require_once '../app/models/' . $model . '.model.php';
            return new $model;
        }

        protected function view($view, $data = []){
            require_once '../app/views/' . $view . '.php';
        }
        
    }