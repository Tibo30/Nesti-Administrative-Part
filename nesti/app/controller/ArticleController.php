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
        }else if (($this->_url) == "article_picture") {
            $this->editPicture(); // this is the method called by the fetch API with the article/delete ROOT.
        } 
        else if (($this->_url) == "article_delete") {
            $this->deleteArticle(); // this is the method called by the fetch API with the article/delete ROOT.
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
                $this->articleDAO->editArticle($articleEdit, "articleUserName");
                // $data['articleEdit'] = $articleEdit;
            }
        }
        // return $data;
    }

    private function deleteArticle()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idArticle = $_POST["idArticle"]; // first we get the id of the article
            $articleEdit = $this->articleDAO->getArticle($idArticle); // we get the article from the database
            $articleEdit->setState("b"); // we change is state in local
            $this->articleDAO->editArticle($articleEdit, "state"); // we change is state in the database
            $articles = $this->articleDAO->getArticles(); // we get back all the articles from the database
            $index = 0;
            // in this loop we prepare the return data from the fetch
            foreach ($articles as $article) {
                $data['articles'][$index]['id'] = $article->getIdArticle();
                $data['articles'][$index]['name'] = $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName();
                $data['articles'][$index]['selling_price'] = round(($article->getPrice()->getPrice()), 2);
                $data['articles'][$index]['type'] = $article->getType();
                $data['articles'][$index]['last_import'] = $article->getLastImport()->getImportDate();
                $data['articles'][$index]['state'] = $article->getState();
                $data['articles'][$index]['stock'] = "";
                $data['articles'][$index]['action'] = '<a href="' . BASE_URL . 'article/edit/' .  $article->getIdArticle() . ' "data-id=' . $article->getIdArticle() . '>Modify</br></a>
                <a id="allArticleDelete" class="btn-delete-article" onclick="allArticleDelete()" data-id=' . $article->getIdArticle() . '>Delete</a>';
                $index++;
            }
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }

    private function editPicture(){
        $data = [];
        $data['success'] = false;
        // $data['name']=$_FILES['image']['name'];
        if (isset($_FILES) && !empty($_FILES)){
            $data['success'] = true;
        }
       
        // $data['name']=$_FILES['image']['name'];
        // $data['tmp']=$_FILES['image']['tmp_name'];
        echo json_encode($data);
        die;
    }
}
