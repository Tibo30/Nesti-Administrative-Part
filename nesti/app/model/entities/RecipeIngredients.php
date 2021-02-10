<?php
class RecipeIngredients
{
    private $quantity;
    private $order;
    private UnitMeasure $unitMeasure;
    private $idRecipe;
    private Ingredients $ingredient;

    public function hydration($data)
    {
        $this->quantity = $data['quantity'];
        $this->order = $data['order'];
        $this->unitMeasure = $data['unitMeasure'];
        $this->idRecipe = $data['id_recipes'];
        $this->ingredient = $data['ingredient'];
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
        return $this->unitMeasure;
    }

    /**
     * Set the value of unitMeasure
     *
     * @return  self
     */
    public function setUnitMeasure($unitMeasure)
    {
        $this->unitMeasure = $unitMeasure;

        return $this;
    }

    /**
     * Get the value of ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set the value of ingredient
     *
     * @return  self
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }
}
