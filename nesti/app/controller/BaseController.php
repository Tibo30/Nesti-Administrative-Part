<?php
require_once(PATH_VIEW.'View.php');

abstract class BaseController{
    protected View $_view;
    protected $_url;
    protected $_data=[];

    public function __construct($url){
        if (isset($_GET["url"]) && count($url)>1){
            throw new Exception ('Page introuvable');
        } else {
            $this->_url= $url[0];
            $this->initialize();
        }
    }

    public function getView():View{
        return $this->_view;
    }

    public function getData(){
        return $this->_data;
    }

    protected abstract function initialize();
}