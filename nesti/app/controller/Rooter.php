<?php
//require_once(PATH_VIEW . 'View.php');
class Rooter
{
    private $_ctrl;

    public function rootReq($urlString)
    {
        try {

         
            //echo "rooter / ";
           // if ($urlString!="connection"){
                $url = '';
                // if (!$urlString) {
                //     $urlString = "recipe";
                // }
                // the controller is included according to the user's action
    
                $url = explode('/', $urlString);
    
                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = $controller . 'Controller';
                $controllerFile = PATH_CONTROLLER . $controllerClass . '.php'; // path of the controllerFile
    
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                    $this->_ctrl = new $controllerClass($url); // instance of the controller class
                } else {
                    throw new Exception('Page introuvable');
                }
            // } else {
            //     require_once(PATH_VIEW."/content/connection_content.php");
            // }

            
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            echo $errorMsg;
            require_once(PATH_ERRORS . 'error404.html');
        }
    }

    public function getController()
    {
        return $this->_ctrl;
    }
}
