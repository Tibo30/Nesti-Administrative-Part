<?php
class Lot{
    private $refOrder;
    private $unitCost;
    private $boughtQuantity;
    private $receivedDate;
    private $idArticle;
    
    public function hydration($data)
    {
        $this->refOrder = $data['ref_order'];
        $this->unitCost = $data['id_article'];
        $this->boughtQuantity = $data['bought_quantity'];
        $this->receivedDate = $data['received_date'];
        $this->idArticle = $data['id_article'];
       
        return $this;
    }


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
     * Get the value of unitCost
     */ 
    public function getUnitCost()
    {
        return $this->unitCost;
    }

    /**
     * Set the value of unitCost
     *
     * @return  self
     */ 
    public function setUnitCost($unitCost)
    {
        $this->unitCost = $unitCost;

        return $this;
    }

    /**
     * Get the value of boughtQuantity
     */ 
    public function getBoughtQuantity()
    {
        return $this->boughtQuantity;
    }

    /**
     * Set the value of boughtQuantity
     *
     * @return  self
     */ 
    public function setBoughtQuantity($boughtQuantity)
    {
        $this->boughtQuantity = $boughtQuantity;

        return $this;
    }

    /**
     * Get the value of receivedDate
     */ 
    public function getReceivedDate()
    {
        return $this->receivedDate;
    }

    /**
     * Set the value of receivedDate
     *
     * @return  self
     */ 
    public function setReceivedDate($receivedDate)
    {
        $this->receivedDate = $receivedDate;

        return $this;
    }

    /**
     * Get the value of idArticle
     */ 
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set the value of idArticle
     *
     * @return  self
     */ 
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }
}