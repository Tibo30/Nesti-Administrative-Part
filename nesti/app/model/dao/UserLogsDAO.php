<?php
class UserLogsDAO extends ModelDAO
{
    public function getLog($idUser)
    {
        $req = self::$_bdd->prepare('SELECT * FROM user_logs WHERE id_users=:id ORDER BY connection_date DESC LIMIT 1');
        $req->execute(array("id" => $idUser));
        $userlog = new UserLog();
        if ($log =  $req->fetch()) {
            $userlog->hydration($log);
        }
        $req->closeCursor(); // release the server connection so it's possible to do other query
        return $userlog;
    }
}
