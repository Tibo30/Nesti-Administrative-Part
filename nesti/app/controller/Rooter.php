<?php
class Rooter
{
    private $_ctrl;

    public function rootReq($urlString)
    {
        try {
                $url = explode('/', $urlString); // get the list of words in the url
                $controller = ucfirst(strtolower($url[0])); // take the first one
                $controllerClass = $controller . 'Controller'; // the name of the controller class is defined by the first word in the url and then "Controller"
                $controllerFile = PATH_CONTROLLER . $controllerClass . '.php'; // path of the controllerFile
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                    $this->_ctrl = new $controllerClass($url); // instance of the controller class
                } else {
                    throw new Exception('');
                }     
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            echo $errorMsg;
            require_once(PATH_ERRORS . 'error404.html');
            die();
        }
    }

    public function getController()
    {
        return $this->_ctrl;
    }
}
