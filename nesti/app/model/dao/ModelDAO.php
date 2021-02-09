<?php

class ModelDAO extends Database
{

    protected function getAll($table, $obj)
    {
        $var = [];
        //$req=$this->getBdd()->prepare('SELECT * FROM '.$table);
        $req = self::$_bdd->prepare('SELECT * FROM ' . $table);
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {

            foreach ($data as $row) {

                $item = new $obj();
                $var[] = $item->hydration($row);
            }
            //echo "donnees : ";
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    protected function getPicture($idPicture)
    {
        $req = self::$_bdd->prepare('SELECT * FROM pictures WHERE id_pictures=:id');
        $req->execute(array("id" => $idPicture));
        $picture =  $req->fetch();
        $pictureObject = new Picture();
        $pictureObject->hydration($picture);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $pictureObject;
    }
    
    public function getUnitMeasure($idUnit){
        $req = self::$_bdd->prepare('SELECT * FROM unit_measures WHERE id_unit_measures=:id'); 
        $req->execute(array("id" => $idUnit));
        $unit =  $req->fetch();
        $unitObject = new UnitMeasure();
        $unitObject->hydration($unit);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $unitObject;
    }
    


// while($data = $req->fetchAll(PDO::FETCH_CLASS,"Recipe")){
//     // $var[]= new $obj($data);
//  }

}