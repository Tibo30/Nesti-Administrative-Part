<?php
class UserDAO extends ModelDAO
{
    public function addUser($userAdd){
        echo($userAdd->getUsername());
        $req = self::$_bdd->prepare('INSERT INTO users (lastname,firstname,username,email,password,state,creation_date,address1,address2,postcode,id_city) VALUES (:lastname, :firstname, :username, :email, :password, :state, CURRENT_TIMESTAMP, :address1, :address2, :postcode, :id_city) ');
        $req->execute(array("lastname"=>$userAdd->getLastname(),"firstname"=>$userAdd->getFirstname(),"username"=>$userAdd->getUsername(),"email"=>$userAdd->getEmail(),"password"=>$userAdd->getPassword(),"state"=>$userAdd->getState(),"address1"=>$userAdd->getAddress1(),"address2"=>$userAdd->getAddress2(),"postcode"=>$userAdd->getPostCode(),"id_city"=>$userAdd->getIdCity()));
   
var_dump(array("lastname"=>$userAdd->getLastname(),"firstname"=>$userAdd->getFirstname(),"username"=>$userAdd->getUsername(),"email"=>$userAdd->getEmail(),"password"=>$userAdd->getPassword(),"state"=>$userAdd->getState(),"address1"=>$userAdd->getAddress1(),"address2"=>$userAdd->getAddress2(),"postcode"=>$userAdd->getPostCode(),"id_city"=>$userAdd->getIdCity()));   
 }
    
    public function getUsers()
    {
        $var = [];
        $use = [];
        $log = [];
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.address1, u.address2, u.postcode,u.id_city FROM users u');
        $req->execute();
        if ($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($data as $row) {
                // know the role
                $roles = $this->getRole($row['id_users']);
                $user = new User();
                $row['roles']=$roles;
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

    public function getRole($idUser)
    {
        $role = [];
        $reqChief = self::$_bdd->prepare('SELECT id_users FROM chief WHERE id_users=:id');
        $reqAdmin = self::$_bdd->prepare('SELECT id_users FROM admin WHERE id_users=:id');
        $reqModerator = self::$_bdd->prepare('SELECT id_users FROM moderator WHERE id_users=:id');
        $reqChief->execute(array("id" => $idUser));
        $reqAdmin->execute(array("id" => $idUser));
        $reqModerator->execute(array("id" => $idUser));
        if ($reqChief->rowcount()==1) {
            $role[] = "Chief";
        } 
        if ($reqAdmin->rowcount()==1) {
            $role[] = "Admin";
        }
        if ($reqModerator->rowcount()==1) {
            $role[] = "Moderator";
        } 
        if($reqChief->rowcount()==0&&$reqAdmin->rowcount()==0&&$reqModerator->rowcount()==0) {
            $role[] = "User";
        }
        return $role;
    }

    public function getOneUser($valueId)
    {
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM users WHERE id_users =:id ');
        $req->execute(array("id" => $valueId));
        if ($data = $req->fetch()) {
            $roles = $this->getRole($data['id_users']);
            $user = new User();
            $data['roles'] = $roles;
            $use = $user->hydration($data);
            // create the user log
            $log = $this->getLog($data['id_users']);
            $var = ['user' => $use, 'log' => $log];
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $var;
    }

    public function getChief($idChief)
    {
        $req = self::$_bdd->prepare('SELECT u.id_users, u.lastname, u.firstname, u.username, u.email, u.password, u.state, u.creation_date, u.address1, u.address2, u.postcode, u.id_city FROM users u JOIN chief ch ON u.id_users = ch.id_users WHERE ch.id_users=:id');
        $req->execute(array("id" => $idChief));
        $chief =  $req->fetch();
        $chief['roles']="Chief";
        $chiefUser = new User();
        $chiefUser->hydration($chief);
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $chiefUser;
    }

}
