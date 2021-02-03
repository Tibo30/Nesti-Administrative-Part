<?php
class Ingredients{
    private $id_ingredients;

    /**
     * Get the value of id_ingredients
     */ 
    public function getId_ingredients()
    {
        return $this->id_ingredients;
    }

    /**
     * Set the value of id_ingredients
     *
     * @return  self
     */ 
    public function setId_ingredients($id_ingredients)
    {
        $this->id_ingredients = $id_ingredients;

        return $this;
    }
}