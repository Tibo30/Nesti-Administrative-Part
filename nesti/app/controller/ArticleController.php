<?php
require_once(BASE_DIR.PATH_VIEW . 'View.php');

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
            if (isset($idArticle)) {
                $data =  $this->article($idArticle);
            }
        } else if (($this->_url) == "article_editarticle") {
            $this->editArticle(); // this is the method called by the fetch API with the article/editarticle ROOT.
        } else if (($this->_url) == "article_picture") {
            $this->editPicture(); // this is the method called by the fetch API with the article/picture ROOT.
        } else if (($this->_url) == "article_delete") {
            $this->deleteArticle(); // this is the method called by the fetch API with the article/delete ROOT.
        } else if (($this->_url) == "article_deletepicture") {
            $this->deletePictureArticle(); // this is the method called by the fetch API with the article/deletepicture ROOT.
        } else if (($this->_url) == "article_orders") {
            $data = $this->orders();
        } else if (($this->_url) == "article_order") {
            $this->order(); // this is the method called by the fetch API with the article/order ROOT.
        }
        $data["title"] = "Articles";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
    }

    /**
     * This method is used to display all the articles
     */
    private function articles()
    {
        $articles = $this->articleDAO->getArticles();
        $data = ['articles' => $articles];
        return $data;
    }

    /**
     * This method is used to display an article (edit page)
     */
    private function article($idArticle)
    {
        $article = $this->articleDAO->getArticle($idArticle);
        $data = ['article' => $article];
        return $data;
    }

    /**
     * This method is used to display all the imported Articles
     */
    private function importedArticles()
    {
        $articles = $this->articleDAO->getimportedArticles();
        $data = ['articles' => $articles];
        return $data;
    }

    /**
     * This method is used to display all the orders
     */
    private function orders()
    {
        $ordersDAO = new OrderDAO();
        $orders = $ordersDAO->getOrders();
        $data = ['orders' => $orders];
        return $data;
    }

    /**
     * this is the Ajax method to edit an Article
     */
    private function editArticle()
    {
        $data = [];
        $data['success'] = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idArticle = filter_input(INPUT_POST, "id_article", FILTER_SANITIZE_STRING);
            $articleUserName = filter_input(INPUT_POST, "articleUserName", FILTER_SANITIZE_STRING);
            $articleState = filter_input(INPUT_POST, "articleState", FILTER_SANITIZE_STRING);

            $articleEdit = $this->articleDAO->getArticle($idArticle); // get all the info of this article
            $formerArticleState = $articleEdit->getState();
            $formerArticleUserName = $articleEdit->getUserArticleName();

            $articleUserNameError = $articleEdit->setUserArticleName($articleUserName);
            $articleEdit->setState($articleState);

            $errorMessages = ['articleUserName' => $articleUserNameError];
            $data['errorMessages'] = $errorMessages;
            // si bug, remettre null à la place de ""
            if ($articleUserNameError == "") {
                if ($formerArticleUserName != $articleUserName) { // if the article user name changed
                    $this->articleDAO->editArticle($articleEdit, "articleUserName");
                }
                if ($formerArticleState != $articleState) { // if the states changed
                    $this->articleDAO->editArticle($articleEdit, "state");
                }

                $data['articleEdit'] = $articleEdit;
                $data['idArticle'] = $articleEdit->getIdArticle();
                $data['articleFactoryName'] = $articleEdit->getQuantityPerUnit() . " " . $articleEdit->getUnitMeasure()->getName() . " de " .  $articleEdit->getProduct()->getProductName();
                $data['articleUserName'] = $articleEdit->getUserArticleName();
                $data['articlePrice'] = round(($articleEdit->getPrice()->getPrice()), 2);
                $data['articleStock'] = $articleEdit->getStock();
                $data['articleState'] = $articleEdit->getState();
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
    }


    /**
     * this is the Ajax method to delete an Article (change state to Blocked)
     */
    private function deleteArticle()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idArticle = $_POST["idArticle"]; // first we get the id of the article
            $articleEdit = $this->articleDAO->getArticle($idArticle); // we get the article from the database
            $articleEdit->setState("b"); // we change is state in local
            $this->articleDAO->editArticle($articleEdit, "state"); // we change is state in the database
            $data["state"]=$articleEdit->getDisplayState();
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the method called by the fetch API with the article/order ROOT.
     */
    private function order()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idOrder = $_POST["id_order"]; // first we get the id of the order
            $data["id"] = $idOrder;
            $ordersDAO = new OrderDAO();
            $orderLines = $ordersDAO->getOrderLines($idOrder); // we get all the orderLines for this order
            if (count($orderLines) > 0) { // if there is at least one orderLine
                $data['success'] = true;

                $index = 0;
                // in this loop we prepare the return data from the fetch
                foreach ($orderLines as $orderLine) { // we get all the articles of the orderLines
                    $article = $this->articleDAO->getArticle($orderLine->getIdArticle());
                    $data['articles'][$index]['all'] = '<div class="d-flex flex-row justify-content-between"><div>' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " " . $article->getProduct()->getProductName() . " x " . $orderLine->getQuantityOrdered() . '</div>' . '<a id="seeArticle" class="btn-see-article" onclick="" data-id=' . $article->getIdArticle() . '>See</a></div>';
                    $index++;
                }
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to edit Picture of an article
     */
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
                    $picture = $pictureDAO->getPictureByName($picture->getName(), $picture->getExtension()); // get the picture from the database
                    $article = $this->articleDAO->getArticle($iD); // get the article from the DAO
                    $article->setIDPicture($picture->getIdPicture()); // set the id picture of the article
                    $this->articleDAO->editArticle($article, "picture"); // edit the article in the database with this picture
                    $data['MessageDb'] = "The name is already taken in the database. The picture added is the one from the database. Change the name of your picture if you want this one to be added";
                }

                $data["picture"] = $picture->getName() . "." . $picture->getExtension();
                $data["urlPicture"] = BASE_URL . PATH_PICTURES . $data["picture"];
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to delete the Picture of an article
     */
    private function deletePictureArticle()
    {
        $data = [];
        $data['success'] = false;

        if (isset($_POST) && !empty($_POST)) {
            $idArticle = $_POST["id_article"]; // first we get the id of the article
            $article = $this->articleDAO->getArticle($idArticle); // then we get the object article from the database.
            $article->setIDPicture(null);
            $this->articleDAO->editArticle($article, "picture"); // set the picture to null in the database for this article
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }
}
