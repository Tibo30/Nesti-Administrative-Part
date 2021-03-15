<?php
class PictureDAO extends ModelDAO
{
    public function getPicture($idPicture)
    {
        $req = self::$_bdd->prepare('SELECT * FROM pictures WHERE id_pictures=:id');
        $req->execute(array("id" => $idPicture));
        $picture =  $req->fetch();
        $pictureObject = new Picture();
        $pictureObject->hydration($picture);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $pictureObject;
    }

    public function insertPicture($picture)
    {

        $req = self::$_bdd->prepare('INSERT INTO pictures (creation_date, name, extension) VALUES (CURRENT_TIMESTAMP, :name, :extension)');
        $req->execute(array("name"=>$picture->getName(),"extension"=>$picture->getExtension()));
        $last_id = self::$_bdd->lastInsertId();
        return $last_id;
    }
}