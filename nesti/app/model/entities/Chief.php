<?php
class Chief {
    private $idChief;

    /**
     * Get the value of idChief
     */ 
    public function getIdChief()
    {
        return $this->idChief;
    }

    /**
     * Set the value of idChief
     *
     * @return  self
     */ 
    public function setIdChief($idChief)
    {
        $this->idChief = $idChief;

        return $this;
    }
}