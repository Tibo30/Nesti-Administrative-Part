<?php
class RoleDAO extends ModelDAO
{
    /**
     * create roles for a user
     * User $user
     */
    public function createRoles($user)
    {
        $roles = $user->getRoles();

        foreach ($roles as $role) {
            if ($role != "user") {
                $req = self::$_bdd->prepare('INSERT INTO ' . $role . ' (id_users, role_state) VALUES (:id, "a")');
                $req->execute(array("id" => $user->getIdUser()));
                $req->closeCursor(); // release the server connection so it's possible to do other query
            }
        }
    }

     /**
     * create role for a user
     * User $user
     */
    public function createRole($user, $role)
    {
        $req = self::$_bdd->prepare('INSERT INTO ' . $role . ' (id_users, role_state) VALUES (:id, "a")');
        $req->execute(array("id" => $user->getIdUser()));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }

    /**
     * edit roles of user
     * User $userEdit, String $role, String $role_sate
     */
    public function editRole($userEdit, $role, $role_state)
    {
        $req = self::$_bdd->prepare('UPDATE ' . $role . ' SET role_state =:state WHERE id_users=:id');
        $req->execute(array("id" => $userEdit->getIdUser(), "state" => $role_state));
        $req->closeCursor(); // release the server connection so it's possible to do other query
    }

    /**
     * get role state for a user
     * User $userEdit, String $role
     */
    public function getRoleState($userEdit, $role)
    {
        $state = "";
        $req = self::$_bdd->prepare('SELECT * from ' . $role . ' WHERE id_users=:id');
        $req->execute(array("id" => $userEdit->getIdUser()));
        if ($data =  $req->fetch()) {
            $state = $data["role_state"];
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $state;
    }
}
