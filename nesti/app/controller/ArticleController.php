<?php
require_once(PATH_VIEW.'View.php');
require_once(PATH_MODEL.'entities/article.php');

class ArticleController extends BaseController{
    private $articleDAO;
    
    public function initialize(){
        $this->articles();
    }

    private function articles(){
        $this->articleDAO = new ArticleDAO();
        $articles = $this->articleDAO->getArticles();
        $this->_view = new View($this->_url);
        $this->_data = ['articles'=>$articles,'url'=>$this->_url,"title"=>"Articles"];
  
    }

    
}