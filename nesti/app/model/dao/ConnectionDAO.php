<?php
class ConnectionDAO extends ModelDAO{
   
   
    public function checkPassword($email, $password)
    {
        $user = new User();
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.adress1, u.adress2, u.postcode, u.id_city FROM users u WHERE u.email=:email AND u.password=:password');
        $req->execute(array("email" => $email, "password" => $password));
        if ($data =  $req->fetch()){
            $user->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $user;
    }
}