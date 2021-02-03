<?php
class OrderLine{
    private $idOrder;
    private $idArticle;
    private $quantityOrdered;
    

    /**
     * Get the value of idOrder
     */ 
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * Set the value of idOrder
     *
     * @return  self
     */ 
    public function setIdOrder($idOrder)
    {
        $this->idOrder = $idOrder;

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

    /**
     * Get the value of quantityOrdered
     */ 
    public function getQuantityOrdered()
    {
        return $this->quantityOrdered;
    }

    /**
     * Set the value of quantityOrdered
     *
     * @return  self
     */ 
    public function setQuantityOrdered($quantityOrdered)
    {
        $this->quantityOrdered = $quantityOrdered;

        return $this;
    }
}