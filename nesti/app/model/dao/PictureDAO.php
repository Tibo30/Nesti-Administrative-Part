<?php
class PictureDAO extends ModelDAO
{
    /**
     * get picture
     * int $idPicture
     */
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

    /**
     * check if a picture exists
     * String $pictureName, String $pictureExtension
     */
    public function doesPictureExist($pictureName, $pictureExtension)
    {
        $exist=false;
        $req = self::$_bdd->prepare('SELECT * FROM pictures WHERE name=:name AND extension=:extension');
        $req->execute(array("name" => $pictureName,"extension" => $pictureExtension));
        if ($req->rowcount()==1) {
            $exist = true;
        } 
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $exist;
    }

    /**
     * get picture by name
     * String $pictureName, String $pictureExtension
     */
    public function getPictureByName($pictureName, $pictureExtension)
    {
        $req = self::$_bdd->prepare('SELECT * FROM pictures WHERE name=:name AND extension=:extension');
        $req->execute(array("name" => $pictureName,"extension" => $pictureExtension));
        $pictureObject = new Picture();
        if($picture =  $req->fetch()){
            $pictureObject->hydration($picture);
        }        
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $pictureObject;
    }

    /**
     * insert picture in database
     * Picture $picture
     */
    public function insertPicture($picture)
    {

        $req = self::$_bdd->prepare('INSERT INTO pictures (creation_date, name, extension) VALUES (CURRENT_TIMESTAMP, :name, :extension)');
        $req->execute(array("name"=>$picture->getName(),"extension"=>$picture->getExtension()));
        $last_id = self::$_bdd->lastInsertId();
        return $last_id;
    }
}