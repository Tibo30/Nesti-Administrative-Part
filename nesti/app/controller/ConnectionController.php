<?php
require_once(PATH_VIEW.'View.php');

class ConnectionController extends BaseController{
    private $connectionDAO;
    
    public function initialize(){
        $this->articles();
    }

    private function articles(){
        $this->connectionDAO = new ConnectionDAO();
        $this->_view = new View('connection');
        $this->_data = ['url'=>$this->_url,"title"=>"Connection"];
  
    }

    
}