<?php
class RecipeIngredients{
    private $quantity;
    private $order;
    private $idUnitMeasure;
    private $idRecipe;
    private $idIngredient;

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */ 
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of idUnitMeasure
     */ 
    public function getIdUnitMeasure()
    {
        return $this->idUnitMeasure;
    }

    /**
     * Set the value of idUnitMeasure
     *
     * @return  self
     */ 
    public function setIdUnitMeasure($idUnitMeasure)
    {
        $this->idUnitMeasure = $idUnitMeasure;

        return $this;
    }

    /**
     * Get the value of idRecipe
     */ 
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }

    /**
     * Set the value of idRecipe
     *
     * @return  self
     */ 
    public function setIdRecipe($idRecipe)
    {
        $this->idRecipe = $idRecipe;

        return $this;
    }

    /**
     * Get the value of idIngredient
     */ 
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Set the value of idIngredient
     *
     * @return  self
     */ 
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = $idIngredient;

        return $this;
    }
}