<?php

class App{

    protected $controller = 'dashboard';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if(isset($url[0]))
        {
            if(file_exists('../app/controllers/'. $url[0] . '.contr.php'))
            {
                $this->controller = $url[0];
                $option = $this->controller . '.contr.php';
            }
            else
            {
                $this->controller = 'errors';
                $this->method = 'not_found';
                $option = $this->controller . '.contr.php';
                unset($url[0]);
            }
        }else{
            $option = $this->controller . '.contr.php';
        }

        require_once '../app/controllers/'. $option;

        $this->controller = new $this->controller;

        
        if(isset($url[1]))
        {
            if(isset($url[2]))
            {
                if (file_exists('../app/controllers/'. $url[0] .'/' . $url[1] . '.contr.php'))
                {

                    $this->controller = $url[1];
                    unset($url[1]);
                    
                    $option =  $url[0] .'/'. $this->controller . '.contr.php';
                    require_once '../app/controllers/'. $option;

                    if(method_exists($this->controller, $url[2]))
                    {
                        $this->method = $url[2];
                        unset($url[2]);
                    }else{
                        $this->controller = 'errors';
                        $this->method = 'not_found';
                        $option = $this->controller . '.contr.php';
                        unset($url[2]);
                    }

                }else{
                    if(method_exists($this->controller, $url[1]))
                    {
                        $this->method = $url[1];
                        unset($url[1]);
                    }else{
                        $this->controller = 'errors';
                        $this->method = 'not_found';
                        $option = $this->controller . '.contr.php';
                        unset($url[1]);
                    }
                }

                unset($url[0]);
                require_once '../app/controllers/'. $option;
                $this->controller = new $this->controller;

            }else{
                if(method_exists($this->controller, $url[1]))
                {
                    $this->method = $url[1];
                    unset($url[1]);
                }
                else
                {
                    $this->controller = 'errors';
                    $this->method = 'not_found';
                    unset($url[1]);
                    
                    require_once '../app/controllers/'. $this->controller . '.contr.php';
                    $this->controller = new $this->controller;
                }
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }


    protected function parseUrl()
    {
        if(isset($_GET['url'])){
            return $url = explode('/', str_replace('-', ' ', filter_var(str_replace(' ', '-', rtrim($_GET['url'], '/')), FILTER_SANITIZE_URL)));
        }
    }

}