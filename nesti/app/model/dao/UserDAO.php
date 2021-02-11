<?php
class UserDAO extends ModelDAO
{

    // public function getUsers()
    // {
    //     return $this->getAll('users', 'User');
    // }

    // public function getUsers()
    // {
    //     $var = [];
    //     $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.adress1, u.adress2, u.postcode,u.id_city FROM users u');
    //     $req->execute();
    //     if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
    //         foreach ($data as $row) {
    //             $user = new User();
    //             $var[]=$user->hydration($row);
    //         }
    //     }
    //     $req->closeCursor(); // release the server connection so it's possible to do other query
    //     return $var;
    // }

    public function getUsers()
    {
        $var = [];
        $use = [];
        $log = [];
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.adress1, u.adress2, u.postcode,u.id_city FROM users u');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {

                // know the role
                $role = $this->getRoles($row['id_users']);
                switch ($role) {
                    case "Chief":
                        $user = new Chief();
                        break;
                    case "Admin":
                        $user = new Admin();
                        break;
                    case "Moderator":
                        $user = new Moderator();
                        break;
                }
                $use[] = $user->hydration($row);

                // create the user log
                $log[] = $this->getLog($row['id_users']);
            }
            $var = ['users' => $use, 'log' => $log];
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getLog($idUser)
    {
        $req = self::$_bdd->prepare('SELECT id_users, id_user_logs, connection_date FROM user_logs WHERE id_users=:id ORDER BY connection_date DESC LIMIT 1');
        $req->execute(array("id" => $idUser));
        $userLog = new UserLog();
        if ($data = $req->fetch()) {
            $userLog->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $userLog;
    }

    public function getRoles($idUser)
    {
        $role = "";
        $reqChief = self::$_bdd->prepare('SELECT id_users FROM chief WHERE id_users=:id');
        $reqAdmin = self::$_bdd->prepare('SELECT id_users FROM admin WHERE id_users=:id');
        $reqModerator = self::$_bdd->prepare('SELECT id_users FROM moderator WHERE id_users=:id');
        $reqChief->execute(array("id" => $idUser));
        $reqAdmin->execute(array("id" => $idUser));
        $reqModerator->execute(array("id" => $idUser));
        if ($reqChief->fetch()) {
            $role = "Chief";
        } else if ($reqAdmin->fetch()) {
            $role = "Admin";
        } else if ($reqModerator->fetch()) {
            $role = "Moderator";
        }
        return $role;
    }

    public function getOneUser($valueId)
    {
        $req = self::$_bdd->prepare('SELECT * FROM users WHERE id_users =:id ');
        $req->execute(array("id" => $valueId));
        $user = new User();
        if ($data = $req->fetch()) {
            $user->hydration($data);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $user;
    }

    // public function getOneUser($valueId)
    // {
    //     $req = self::$_bdd->prepare('SELECT * FROM users WHERE id_users =:id ');
    //     $req->execute(array("id" => $valueId));
    //     if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
    //         foreach ($data as $row) {
    //             $item = new User();
    //             $var[] = $item->hydration($row);
    //         }
    //         //echo "donnee sql / ";
    //     }
    //     $req->closeCursor(); // release the server connection so it's possible to do other query
    //     return $var;
    // }

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
