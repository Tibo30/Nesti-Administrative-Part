<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/article.php');

class ArticleController extends BaseController
{
    private $articleDAO;

    public function initialize()
    {
        $data[] = null;
        $this->articleDAO = new ArticleDAO();
        if (($this->_url) == "article") {
            $data =  $this->articles();
        } else if (($this->_url) == "article_import") {
            $data =  $this->importedArticles();
        }
        else if (($this->_url) == "article_edit") {
            $data =  $this->importedArticles();
        }
        $data["title"] = "Articles";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
    }

    private function articles()
    {
        // $import=[];
        // $price=[];
        // $articles = $this->articleDAO->getArticles();
        // foreach($articles as $article){
        //     $import[]=
        // }
        $articles = $this->articleDAO->getArticles();
        $data = ['articles' => $articles];
        return $data;
    }

    private function importedArticles()
    {
        $articles = $this->articleDAO->getimportedArticles();
        $data = ['articles' => $articles];
        return $data;
    }
}
