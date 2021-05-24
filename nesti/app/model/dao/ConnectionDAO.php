<?php
class ConnectionDAO extends ModelDAO
{
    /**
     * add log in database
     * int $idUser
     */
    public function addUserLog($idUser)
    {
        $req = self::$_bdd->prepare('INSERT INTO user_logs (connection_date,id_users) VALUES (CURRENT_TIMESTAMP,:id)');
        $req->execute(array("id" => $idUser));
        $req->fetch();
    }

    /**
     * get user according to email/username
     * String $email
     */
    public function getPassword($email)
    {
        $user = new User();
        $req = self::$_bdd->prepare('SELECT * FROM users WHERE email=:email OR username=:username');
        $req->execute(array("email" => $email, "username" => $email));
        if ($data =  $req->fetch()) {
            $user->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $user;
    }
}
