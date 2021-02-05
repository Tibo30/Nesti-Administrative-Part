<?php
class View{
    private $_file;

    public function __construct($action){
        $this->_file = PATH_VIEW.'content/'.$action.'_content.php';
        //echo "view / ";
    }

    public function getFile(){
        return $this->_file;
    }
}