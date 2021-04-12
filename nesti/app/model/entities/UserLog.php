<?php
class UserLog{
    private $idUserLog;
    private $connectionDate;
    private $idUser;

    public function hydration($data){
        $this->idUserLog=$data['id_user_logs'];
        $this->connectionDate=$data['connection_date'];
        $this->idUser=$data['id_users'];
        return $this;
    }



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
     * Get the display date
     */ 
    public function getDisplayDate()
    {
        $date = new DateTime($this->connectionDate);
        return $date->format('j F Y \a\t H\hi');
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