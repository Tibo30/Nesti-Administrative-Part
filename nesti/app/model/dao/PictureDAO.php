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
}