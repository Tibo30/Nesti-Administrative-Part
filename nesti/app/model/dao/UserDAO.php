<?php
class UserDAO extends ModelDAO{
    
    public function getUsers(){
        return $this->getAll('users','User');
    }

    public function getOneUser($valueId){
        $req=self::$_bdd->prepare('SELECT * FROM users WHERE id_users =:id ');
        $req->execute(array("id" => $valueId));
        return $req->fetch();
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }
}