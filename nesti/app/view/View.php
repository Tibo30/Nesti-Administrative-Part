<?php
class View{
    private $_file;

    public function __construct($action){
        $this->_file = BASE_DIR.PATH_VIEW.'content/'.$action.'_content.php';
        //echo "view / ";
    }

    public function getFile(){
        return $this->_file;
    }
}