<?php
require_once(PATH_VIEW . 'View.php');

class ConnectionController extends BaseController
{
    private $connectionDAO;

    public function initialize()
    {
        $this->connectionDAO = new ConnectionDAO();
        if (empty($_POST)) {
            
            $this->_view = new View('connection');
            $this->_data = ['url' => $this->_url, "title" => "Connection"];
        } else {
            $mySession = new Session();
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING); // mettre sanitize encoded après ?
            $activUser =  $this->connectionDAO->checkPassword($email, $password);
            if (($activUser->getIdUser()) != 0) {
                $mySession->connectUser($activUser->getIdUser());
                $_SESSION["lastname"] = $activUser->getLastname();
                $_SESSION["firstname"] = $activUser->getFirstname();
                header('Location:' . BASE_URL . "recipe");
                die();
            } else {
                header('Location:' . BASE_URL . "connection");
            }
        }
    }
}
