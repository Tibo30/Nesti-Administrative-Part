<?php
class LotDAO extends ModelDAO
{
    
    /**
     * get all lots for an article
     * int $idArticle
     */
    public function getLots($idArticle){
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM lots WHERE id_article=:id');
        $req->execute(array("id" => $idArticle));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $lot=new Lot();
                $var[] = $lot->hydration($row);
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    /**
     * get lot for an article and an order
     * int $idArticle, int $idOrder
     */
    public function getLot($idArticle, $idOrder)
    {
        $req = self::$_bdd->prepare('SELECT * FROM lots WHERE id_article=:idArticle AND ref_order=:idOrder');
        $req->execute(array("idArticle" => $idArticle,"idOrder" => $idOrder));
        $lot=new Lot();
        if ($data = $req->fetch()) {
            $lot->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $lot;
    }

    /**
     * get all the lots by day
     * String $day
     */
    public function getLotsByDay($day)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM lots WHERE received_date LIKE :date"%"');
        $req->execute(array("date" => $day));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $lot = new Lot();
                $lot->hydration($row);
                $var[] = $lot;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }
    
}