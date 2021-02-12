<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/user.php');

class UserController extends BaseController
{
    private $userDAO;

    public function initialize()
    {
        $data[] = null;
        $this->userDAO = new UserDAO();

        if ($this->_url == "user") {
           $data= $this->users();
        } else if ($this->_url == "user_edit") {
            $idUser = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idUser)) {
               $data= $this->modifyUser($idUser);
            }
        } else if ($this->_url == "user_add"){

        }
        $data["title"] = "Users";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
    }

    private function users()
    {

        $user = $this->userDAO->getUsers();

        $data = ['users' => $user['users'], 'logs' => $user['log'], 'url' => $this->_url, "title" => "User"];
        return $data;
    }

    private function modifyUser($idUser)
    {
        $user = $this->userDAO->getOneUser($idUser);
        $data = ['user' => $user['user'], 'log' => $user['log'], 'url' => $this->_url, "title" => "User"];
        return $data;
    }
}
