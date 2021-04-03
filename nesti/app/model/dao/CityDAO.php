<?php
class CityDAO extends ModelDAO
{
    public function doesCityExists($cityname)
    {
        $req = self::$_bdd->prepare('SELECT * FROM city WHERE city_name=:name');
        $req->execute(array("name" => $cityname));
        $cityObject = new City();
        if ($data = $req->fetch()) {
            $cityObject->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $cityObject;

        // $exist = false;
        // $req = self::$_bdd->prepare('SELECT * FROM city WHERE city_name=:name');
        // $req->execute(array("name" => $cityname));
        // if ($req->rowcount() == 1) {
        //     $exist = true;
        // }
        // $req->closeCursor(); // release the server connection so it's possible to do other query
        // return $exist;
    }

    public function getCityById($idCity)
    {
        $req = self::$_bdd->prepare('SELECT * FROM city WHERE id_city=:id');
        $req->execute(array("id" => $idCity));
        $cityObject = new City();
        if ($city =  $req->fetch()){
            $cityObject->hydration($city);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $cityObject;
    }

    public function createCity($cityName)
    {
        $req = self::$_bdd->prepare('INSERT INTO city (city_name) VALUES (:name)');
        $req->execute(array("name" => $cityName));
        $last_id = self::$_bdd->lastInsertId();
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $last_id;
    }

}