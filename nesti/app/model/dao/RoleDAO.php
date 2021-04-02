<?php
class RoleDAO extends ModelDAO
{

    public function createRoles($user)
    {
        $roles = $user->getRoles();
        
        foreach ($roles as $role) {
            $req = self::$_bdd->prepare('INSERT INTO ' . $role . ' (id_users) VALUES (:id)');
            $req->execute(array("id" => $user->getIdUser()));
            $req->closeCursor(); // release the server connection so it's possible to do other query
        }
    }
}
