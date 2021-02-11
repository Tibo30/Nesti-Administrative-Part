<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/user.php');

class UserController extends BaseController
{
    private $userDAO;

    public function initialize()
    {
        if ($this->_url == "user") {
            $this->users();
        } else if ($this->_url == "user_edit") {
            $idUser = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idUser)) {
                $this->modifyUser($idUser);
            }
        }
    }

    private function users()
    {
        $this->userDAO = new UserDAO();

        $data = $this->userDAO->getUsers();
        $this->_view = new View($this->_url);
        $this->_data = ['users' => $data['users'], 'logs' => $data['log'], 'url' => $this->_url, "title" => "User"];
    }

    private function modifyUser($idUser)
    {
        $this->userDAO = new UserDAO();
        $data = $this->userDAO->getOneUser($idUser);
        $this->_view = new View($this->_url);
        $this->_data = ['user' => $data['user'], 'log' => $data['log'], 'url' => $this->_url, "title" => "User"];
    }
}
