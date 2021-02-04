<?php
require_once(PATH_VIEW.'View.php');

class UserController extends BaseController{
    private $userDAO;

    public function initialize(){
        $this->users();
    }

    private function users(){
        $this->userDAO = new UserDAO();

        $users = $this->userDAO->getUsers();
        
        $this->_view = new View('User');
        $this->_data = ['user'=>$users,'url'=>$this->_url,"title"=>"User"];
  
    }
}