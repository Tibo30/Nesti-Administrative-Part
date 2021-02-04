<?php
require_once(PATH_VIEW.'View.php');

class RecipeController extends BaseController{
    private $recipeDAO;

    public function initialize(){
        $this->recipes();
    }

    private function recipes(){
        $this->recipeDAO = new RecipeDAO();

        $recipes = $this->recipeDAO->getRecipes();
        
        $this->_view = new View('Recipe');
        $this->_data = ['recipes'=>$recipes,'url'=>$this->_url,"title"=>"Recipes"];
  
    }
}