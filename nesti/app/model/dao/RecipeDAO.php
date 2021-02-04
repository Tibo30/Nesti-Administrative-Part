<?php
class RecipeDAO extends ModelDAO{
    
    public function getRecipes(){
        return $this->getAll('recipes','Recipe');
    }
}