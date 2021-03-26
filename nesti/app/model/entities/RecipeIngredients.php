<?php
class RecipeIngredients
{
    private $quantity;
    private $order;
    private $iDUnitMeasure;
    private $idRecipe;
    private $iDIngredient;

    public function hydration($data)
    {
        $this->quantity = $data['quantity'];
        $this->order = $data['order_ingredient'];
        $this->iDUnitMeasure = $data['id_unit_measures'];
        $this->idRecipe = $data['id_recipes'];
        $this->iDIngredient = $data['id_ingredients'];
        return $this;
    }

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
    public function setQuantity($quantity) // only int ? or decimals allowed ?????
    {
        $quantityError = "";
        if (empty($quantity)) {
            $quantityError = 'Please enter a Number';
        } else if (!preg_match("/^[0-9]/", $quantity)) {
            $quantityError = "Only numbers allowed";
        } else {
            $this->quantity = $quantity;
        }
        return  $quantityError;
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
     * Get the value of unitMeasure
     */
    public function getUnitMeasure()
    {
        $unitDAO = new UnitMeasureDAO();
        $unit = $unitDAO->getUnitMeasure($this->iDUnitMeasure);
        return $unit;
    }

    /**
     * Get the value of ingredient
     */
    public function getIngredient()
    {
        $productDAO = new ProductDAO();
        $ingredient = $productDAO->getProduct($this->iDIngredient);
        return $ingredient;
    }
    
    /**
     * Get the value of iDUnitMeasure
     */ 
    public function getIDUnitMeasure()
    {
        return $this->iDUnitMeasure;
    }

    /**
     * Set the value of iDUnitMeasure
     *
     * @return  self
     */ 
    public function setIDUnitMeasure($iDUnitMeasure)
    {
        $this->iDUnitMeasure = $iDUnitMeasure;

        return $this;
    }

    /**
     * Get the value of iDIngredient
     */ 
    public function getIDIngredient()
    {
        return $this->iDIngredient;
    }

    /**
     * Set the value of iDIngredient
     *
     * @return  self
     */ 
    public function setIDIngredient($iDIngredient)
    {
        $this->iDIngredient = $iDIngredient;

        return $this;
    }
}
