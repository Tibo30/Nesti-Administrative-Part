<?php
class ImportDAO extends ModelDAO
{
    public function getLastImport($idArticle)
    {
        $req = self::$_bdd->prepare('SELECT * FROM import WHERE id_article=:id ORDER BY import_date DESC LIMIT 1');
        $req->execute(array("id" => $idArticle));
        $importObject = new Import();
        if ($data = $req->fetch()) {
            $importObject->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $importObject;
    }
}
