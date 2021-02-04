<?php
require_once(PATH_VIEW.'View.php');

class ArticleController extends BaseController{
    private $articleDAO;
    
    public function initialize(){
        $this->articles();
    }

    private function articles(){
        $this->articleDAO = new ArticleDAO();
        $articles = $this->articleDAO->getArticles();
        $this->_view = new View('article');
        $this->_data = ['articles'=>$articles,'url'=>$this->_url,"title"=>"Articles"];
  
    }

    
}