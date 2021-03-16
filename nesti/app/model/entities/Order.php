<?php
class Order{
    private $idOrder;
    private $state;
    private $creationDate;
    private $idUser;

    public function hydration($data)
    {
        $this->idOrder = $data['id_order'];
        $this->state = $data['state'];
        $this->creationDate = $data['creation_date'];
        $this->idUser = $data['id_users'];
      
        return $this;
    }


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
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

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

    public function getUser(){
        $userDAO = new UserDAO();
        $user = $userDAO->getOneUser($this->idUser);
        return $user;
    }

    public function getAmount(){
        $amount=0;
        $orderDAO = new OrderDAO();
        $articlePriceDAO = new ArticlePriceDAO();
        $orderLines = $orderDAO->getOrderLines($this->idOrder); // get all the order lines for an order
        foreach($orderLines as $orderLine){
            $price=$articlePriceDAO -> getPrice($orderLine->getIdArticle()); // get the articlePrice object
            $amount+=($orderLine->getQuantityOrdered())*($price->getPrice());
        }
        return $amount;
    }
}