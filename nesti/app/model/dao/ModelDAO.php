<?php

class ModelDAO extends Database
{
    
    protected function getAll($table,$obj){
        $var=[];
        //$req=$this->getBdd()->prepare('SELECT * FROM '.$table);
        $req=self::$_bdd->prepare('SELECT * FROM '.$table);
        $req->execute();
        if($data = $req->fetchAll(PDO::FETCH_ASSOC)){
            
            foreach($data as $row){
                
                $item= new $obj();
                $var[]=$item->hydration($row);
            }
            //echo "donnees : ";
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
        
    }
}


// while($data = $req->fetchAll(PDO::FETCH_CLASS,"Recipe")){
//     // $var[]= new $obj($data);
//  }