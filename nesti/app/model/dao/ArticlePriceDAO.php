<?php
class ArticlePriceDAO extends ModelDAO
{
   /**
    * get the last price of an article
    * int $idArticle
    */
    public function getPrice($idArticle)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM article_price WHERE id_article=:id ORDER BY application_date DESC');
        $req->execute(array("id" => $idArticle));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $priceObject=new ArticlePrice();
                $var[] = $priceObject->hydration($row);;
            }
        }
        if (count($var)>0){
            $lastPriceObject=$var[0];
        } else {
            $lastPriceObject=null;
        }
        
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $lastPriceObject;
    }
}