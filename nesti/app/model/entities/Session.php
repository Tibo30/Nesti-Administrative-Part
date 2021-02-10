<?php
class Session
{

    public function isUserConnected()
    {
        $connected = false;
        if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {
           $connected = true;
        } 
        return $connected;
    }

    public function connectUser($id)
    {
        $_SESSION['idUser'] = $id;
    }

    public function disconnectUser()
    {
        session_unset();
        session_destroy();
    }
}
