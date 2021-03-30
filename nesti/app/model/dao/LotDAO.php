<?php
class LotDAO extends ModelDAO
{
    
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
    
}