<?php
class Import{
    private $refOrder;
    private $idAdmin;
    private $importDate;


    /**
     * Get the value of refOrder
     */ 
    public function getRefOrder()
    {
        return $this->refOrder;
    }

    /**
     * Set the value of refOrder
     *
     * @return  self
     */ 
    public function setRefOrder($refOrder)
    {
        $this->refOrder = $refOrder;

        return $this;
    }

    /**
     * Get the value of idAdmin
     */ 
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

    /**
     * Set the value of idAdmin
     *
     * @return  self
     */ 
    public function setIdAdmin($idAdmin)
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }

    /**
     * Get the value of importDate
     */ 
    public function getImportDate()
    {
        return $this->importDate;
    }

    /**
     * Set the value of importDate
     *
     * @return  self
     */ 
    public function setImportDate($importDate)
    {
        $this->importDate = $importDate;

        return $this;
    }
}
