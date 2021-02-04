<?php
require_once(PATH_VIEW . 'View.php');
class Rooter
{
    private $_ctrl;

    public function rootReq($urlString)
    {
        try {
            //auto loading classes
            spl_autoload_register(function ($class) {
                $sources = array(PATH_MODEL . 'dao/' . $class . '.php', PATH_CTRL . $class . '.php ',  PATH_MODEL . 'entities/' . $class . '.php');
                foreach ($sources as $source) {
                    if (file_exists($source)) {
                        require_once $source;
                    }
                }
            });

           // if ($urlString!="connection"){
                $url = '';
                if (!$urlString) {
                    $urlString = "recipe";
                    echo "bug";
                }
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
            // $this->_view = new View('Error');
            // $this->_view->generate(array('errorMsg'=>$errorMessage));
            require_once(PATH_ERRORS . 'error404.html');
        }
    }

    public function getController()
    {
        return $this->_ctrl;
    }
}
