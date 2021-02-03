<?php
class UserLog{
    private $idUserLog;
    private $connectionDate;
    private $idUser;

    /**
     * Get the value of idUserLog
     */ 
    public function getIdUserLog()
    {
        return $this->idUserLog;
    }

    /**
     * Set the value of idUserLog
     *
     * @return  self
     */ 
    public function setIdUserLog($idUserLog)
    {
        $this->idUserLog = $idUserLog;

        return $this;
    }

    /**
     * Get the value of connectionDate
     */ 
    public function getConnectionDate()
    {
        return $this->connectionDate;
    }

    /**
     * Set the value of connectionDate
     *
     * @return  self
     */ 
    public function setConnectionDate($connectionDate)
    {
        $this->connectionDate = $connectionDate;

        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }
}