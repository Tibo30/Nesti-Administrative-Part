<?php
require_once(PATH_VIEW.'View.php');

abstract class BaseController{
    protected View $_view;
    protected $_url;
    protected $_data=[];

    public function __construct($url){
        if (isset($_GET["url"]) && ($url[0]!="recipe" && count($url)>1)){
            throw new Exception ('Page introuvable');
        } else {
            if ($url[0]=="recipe" && count($url)>1){
                $this->_url=$url[0]."_".$url[1];
               // echo "url : ".$this->_url;
            } else {
                $this->_url= $url[0];
            }
            //echo "base controller / ";
            $this->initialize();
        }
    }

    public function getView():View{
        if(isset($this->_view)){
            return $this->_view;
        }
    }

    public function getData(){
        if (isset($this->_data)){
            return $this->_data;
        }
    }

    protected abstract function initialize();
}