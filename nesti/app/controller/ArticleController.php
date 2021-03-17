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
        } else if (($this->_url) == "article_picture") {
            $this->editPicture(); // this is the method called by the fetch API with the article/delete ROOT.
        } else if (($this->_url) == "article_delete") {
            $this->deleteArticle(); // this is the method called by the fetch API with the article/delete ROOT.
        } else if (($this->_url) == "article_orders") {
            $data=$this->orders(); 
        } else if (($this->_url) == "article_order") {
            $data=$this->order(); // this is the method called by the fetch API with the article/order ROOT.
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

    private function orders(){
        $ordersDAO = new OrderDAO();
        $orders=$ordersDAO->getOrders();
        $data=['orders'=>$orders];
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

    // this is the Ajax method to delete an Article (change state to Blocked)
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

    private function order()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idOrder = $_POST["id_order"]; // first we get the id of the order
            $data["id"]=$idOrder;
            $ordersDAO = new OrderDAO();
            $orderLines=$ordersDAO->getOrderLines($idOrder); // we get all the orderLines for this order
            if (count($orderLines)>0){ // if there is at least one orderLine
                $data['success'] = true;
                $articles=[];
                foreach($orderLines as $orderLine){ // we get all the articles of the orderLines
                    $articles[]=$this->articleDAO->getArticle($orderLine->getIdArticle());
                }
                $index = 0;
                // in this loop we prepare the return data from the fetch
                foreach($articles as $article){
                    $data['articles'][$index]['quantity'] = $article->getQuantityPerUnit();
                    $data['articles'][$index]['unitMeasure'] = $article->getUnitMeasure()->getName();
                    $data['articles'][$index]['product'] = $article->getProduct()->getProductName();
                    $data['articles'][$index]["see"]='<a id="seeArticle" class="btn-delete-article" onclick="" data-id='. $article->getIdArticle() . '>See</a>';
                    $index++;
                }
            }
        }
        echo json_encode($data);
        die;
    }

    // this is the Ajax method to edit Picture of an article
    private function editPicture()
    {
        $data = [];

        if (isset($_FILES) && !empty($_FILES)) {
            $data = [];
            $data['success'] = false;

            $pictureDAO = new PictureDAO;

            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // we define the accepted extensions


            $img = $_FILES['image']['name']; // this is the file name
            $tmp = $_FILES['image']['tmp_name']; // this is the file temporary name

            $path = BASE_DIR . "/public/pictures/pictures/" . strtolower($img); // this is the path that we want for the picture
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION)); // get the extension name of the file
            $position = strrpos($img, "."); // get the position of the "." in the file name

            $data['download'] = is_uploaded_file($tmp = $_FILES['image']['tmp_name']);

            if (in_array($ext, $valid_extensions)) { // if the extension is valid    
                $iD = $_POST['idArticlePicture'];
                $picture = new Picture();
                $picture->setExtension($ext);
                $picture->setName(substr($img, 0, $position));
                if (($pictureDAO->doesPictureExist($picture->getName(), $picture->getExtension())) == false) { // check if the picture/name is not already in the table
                    if (move_uploaded_file($tmp, $path)) { // move the file form temporary folder to right folder (according to path)
                        $data['success'] = true;
                        $idPicture = $pictureDAO->insertPicture($picture, $iD); // insert the picture in the DAO et get the ID back
                        $picture->setIdPicture($idPicture);
                        $article = $this->articleDAO->getArticle($iD); // get the article from the DAO
                        $article->setIDPicture($idPicture); // set the idPicture to the object
                        $this->articleDAO->editArticle($article, "picture"); // edit the article in the database with the new picture
                    } else {
                        $data['errorMove'] = "The picture has not been added"; 
                    }
                } else { // the name is already in the database
                    $data['success'] = true;
                    $picture = $pictureDAO-> getPictureByName($picture->getName(), $picture->getExtension()); // get the picture from the database
                    $article = $this->articleDAO->getArticle($iD); // get the article from the DAO
                    $this->articleDAO->editArticle($article, "picture"); // edit the article in the database with this picture
                    $data['MessageDb'] = "The name is already taken in the database. The picture added is the one from the database. Change the name of your picture if you want this one to be added";
                }

                $data["picture"]=$picture->getName().".".$picture->getExtension();
                $data["urlPicture"]=BASE_URL.PATH_PICTURES.$data["picture"];
            }
        }
        echo json_encode($data);
        die;
    }
}
