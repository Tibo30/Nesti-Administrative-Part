<?php
class View{
    private $_file;

    public function __construct($action){
        $this->_file = PATH_VIEW.'content/'.$action.'_content.php';
    }

    public function getFile(){
        return $this->_file;
    }
}