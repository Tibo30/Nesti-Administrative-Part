<?php
class UserDAO extends ModelDAO
{

    public function getUsers()
    {
        return $this->getAll('users', 'User');
    }

    public function getOneUser($valueId)
    {
        $req = self::$_bdd->prepare('SELECT * FROM users WHERE id_users =:id ');
        $req->execute(array("id" => $valueId));
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                $item = new User();
                $var[] = $item->hydration($row);
            }
            //echo "donnee sql / ";
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getChief($idChief)
    {
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.adress1, u.adress2, u.postcode, u.id_city FROM users u JOIN chief ch ON u.id_users = ch.id_users WHERE ch.id_users=:id');
        $req->execute(array("id" => $idChief));
        $chief =  $req->fetch();
        $chiefUser = new Chief();
        $chiefUser->hydration($chief);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $chiefUser;
    }

    public function getAdmin($idAdmin)
    {
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.adress1, u.adress2, u.postcode, u.id_city FROM users u JOIN admin a ON u.id_users = a.id_users WHERE a.id_users=:id');
        $req->execute(array("id" => $idAdmin));
        $admin =  $req->fetch();
        $adminUser = new Admin();
        $adminUser->hydration($admin);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $adminUser;
    }

    public function getModerator($idModerator)
    {
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.adress1, u.adress2, u.postcode, u.id_city FROM users u JOIN moderator m ON u.id_users = m.id_users WHERE m.id_users=:id');
        $req->execute(array("id" => $idModerator));
        $moderator =  $req->fetch();
        $moderatorUser = new Moderator();
        $moderatorUser->hydration($moderator);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $moderatorUser;
    }

}
