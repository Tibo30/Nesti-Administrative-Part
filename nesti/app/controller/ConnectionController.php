<?php
require_once(PATH_VIEW . 'View.php');

class ConnectionController extends BaseController
{
    private $connectionDAO;

    public function initialize()
    {
        $this->connectionDAO = new ConnectionDAO();
        $this->_data['disconnect'] = false;
        if (empty($_POST)) {
            $this->_view = new View('connection');
            $this->_data ['url']=$this->_url;
            $this->_data ["title"] = "Connection";
            if ($this->_url == "connection_disconnect") {
                $this->_data['disconnect'] = true;
            } 
        } else {
            $this->connectUser();
        }
        
    }

    function connectUser()
    {
        $data = [];
        $data['success'] = false;

        $mySession = new Session();
        $email = filter_input(INPUT_POST, "emailUsername", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING); // mettre sanitize encoded après ?

        $activUser =  $this->connectionDAO->getPassword($email);
        $activeUserId = $activUser->getIdUser();
        $isVerified = password_verify($password, $activUser->getPassword());
        if ($isVerified && $activeUserId != 0) {
            $mySession->connectUser($activeUserId);
            $this->connectionDAO->addUserLog($activeUserId);
            $_SESSION["lastname"] = $activUser->getLastname();
            $_SESSION["firstname"] = $activUser->getFirstname();
            $userDAO = new UserDAO();
            $activUser->setRoles( $userDAO->getRole($activeUserId));
            $_SESSION["roles"] = $activUser->getRoles();
            $data['success'] = true;
            echo json_encode($data);
            die();
        } else {
            $errorEmail = "";
            $errorPassword = "";
            if ($activeUserId == null) {
                $errorEmail = "The Email or Username used is not register";
            }
            if ($isVerified == false) {
                $errorPassword = "The password is incorrect";
            }
            $errorMessages = ['emailUsername' => $errorEmail, 'password' => $errorPassword];
            $data['errorMessages'] = $errorMessages;
            $data['success'] = false;
        }
        echo json_encode($data);
        die;
    }
}
