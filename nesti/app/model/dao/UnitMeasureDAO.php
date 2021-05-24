<?php
class UnitMeasureDAO extends ModelDAO
{
    /**
     * get unit measure by id
     * int $idUnit
     */
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

    /**
     * get unit measure by name
     * String $unitName
     */
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

    /**
     * create unit measure
     * String $unitName
     */
    public function createUnitMeasure($unitName)
    {
        $req = self::$_bdd->prepare('INSERT INTO unit_measures (name) VALUES (:name)');
        $req->execute(array("name" => $unitName));
        $req->closeCursor(); // release the server connection so it's possible to do other query
        $last_id = self::$_bdd->lastInsertId();
        return $last_id;
    }

    /**
     * get all units
     */
    public function getUnits()
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM unit_measures');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $unit = new UnitMeasure();
                $unit->hydration($row);
                $var[] = $unit;
            }
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }
}
