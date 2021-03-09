<?php
class ArticlePriceDAO extends ModelDAO
{
    public function getPrice($idArticle)
    {
        $req = self::$_bdd->prepare('SELECT * FROM article_price WHERE id_article=:id');
        $req->execute(array("id" => $idArticle));
        $priceObject = new ArticlePrice();
        if ($data = $req->fetch()) {
            $priceObject->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $priceObject;
    }
}