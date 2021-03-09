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
}
