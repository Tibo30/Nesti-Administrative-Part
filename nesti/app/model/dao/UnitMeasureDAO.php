<?php
class UnitMeasureDAO extends ModelDAO
{
    public function getUnitMeasure($idUnit)
    {
        $req = self::$_bdd->prepare('SELECT * FROM unit_measures WHERE id_unit_measures=:id');
        $req->execute(array("id" => $idUnit));
        $unitObject = new UnitMeasure();
        if ($data = $req->fetch()) {
            $unitObject->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $unitObject;
    }

    public function getUnitMeasureByName($unitName)
    {
        $req = self::$_bdd->prepare('SELECT * FROM unit_measures WHERE name=:name');
        $req->execute(array("name" => $unitName));
        $unitObject = new UnitMeasure();
        if ($data = $req->fetch()) {
            $unitObject->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $unitObject;
    }

    public function createUnitMeasure($unitName)
    {
        $req = self::$_bdd->prepare('INSERT INTO unit_measures (name) VALUES (:name)');
        $req->execute(array("name" => $unitName));
        $req->closeCursor(); // release the server connection so it's possible to do other query
        $last_id = self::$_bdd->lastInsertId();
        return $last_id;
    }

}
