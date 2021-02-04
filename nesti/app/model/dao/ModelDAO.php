<?php

class ModelDAO extends Database
{
    
    protected function getAll($table,$obj){
        $var=[];
        //$req=$this->getBdd()->prepare('SELECT * FROM '.$table);
        $req=self::$_bdd->prepare('SELECT * FROM '.$table);
        $req->execute();
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            $var[]= new $obj($data);
        }
        return $var;
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }
}
