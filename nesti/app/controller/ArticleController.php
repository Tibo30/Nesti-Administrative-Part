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
        } else if (($this->_url) == "article_edit") {
            $idArticle = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (!empty($_POST)) {
                $this->editArticle($idArticle);
            }
            if (isset($idArticle)) {
                $data =  $this->article($idArticle);
            }
        }
        $data["title"] = "Articles";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
    }

    private function articles()
    {
        $articles = $this->articleDAO->getArticles();
        $data = ['articles' => $articles];
        return $data;
    }

    private function article($idArticle)
    {
        $article = $this->articleDAO->getArticle($idArticle);
        $data = ['article' => $article];
        return $data;
    }

    private function importedArticles()
    {
        $articles = $this->articleDAO->getimportedArticles();
        $data = ['articles' => $articles];
        return $data;
    }

    private function editArticle($idArticle)
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $articleUserName = filter_input(INPUT_POST, "articleUserName", FILTER_SANITIZE_STRING);
            $articleEdit = $this->articleDAO->getArticle($idArticle);
            $articleUserNameError = $articleEdit->setUserArticleName($articleUserName);
            $errorMessages = ['articleUserName' => $articleUserNameError];
            $data['errorMessages'] = $errorMessages;
            if ($articleUserNameError == null) {
                $this->articleDAO->editArticle($articleEdit);
                // $data['articleEdit'] = $articleEdit;
            }
        }
        // return $data;
    }
}
