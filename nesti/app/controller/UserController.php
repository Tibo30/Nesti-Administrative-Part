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
        } 
    }

    private function users()
    {
        $this->userDAO = new UserDAO();

        $users = $this->userDAO->getUsers();

        $this->_view = new View($this->_url);
        $this->_data = ['users' => $users, 'url' => $this->_url, "title" => "User"];
    }
}
