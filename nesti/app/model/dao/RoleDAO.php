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

     // edit roles of user
     public function editRoles($userEdit,$role)
     {
            $req = self::$_bdd->prepare('INSERT INTO ' . $role . ' (id_users) VALUES (:id)');
            $req->execute(array("id" => $userEdit->getIdUser()));
            $req->closeCursor(); // release the server connection so it's possible to do other query
     }

    // public function getRole($idUser)
    // {
    //     $role = [];
    //     $reqChief = self::$_bdd->prepare('SELECT id_users FROM chief WHERE id_users=:id');
    //     $reqAdmin = self::$_bdd->prepare('SELECT id_users FROM admin WHERE id_users=:id');
    //     $reqModerator = self::$_bdd->prepare('SELECT id_users FROM moderator WHERE id_users=:id');
    //     $reqChief->execute(array("id" => $idUser));
    //     $reqAdmin->execute(array("id" => $idUser));
    //     $reqModerator->execute(array("id" => $idUser));
    //     if ($reqChief->rowcount() == 1) {
    //         $role[] = "chief";
    //     }
    //     if ($reqAdmin->rowcount() == 1) {
    //         $role[] = "admin";
    //     }
    //     if ($reqModerator->rowcount() == 1) {
    //         $role[] = "moderator";
    //     }

    //     $role[] = "user";

    //     return $role;
    // }
}
