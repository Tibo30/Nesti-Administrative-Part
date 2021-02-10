<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/recipe.php');

class RecipeController extends BaseController
{
    private $recipeDAO;

    public function initialize()
    {
       
        if (($this->_url) == "recipe") {
            $this->recipes();
        } else if (($this->_url) == "recipe_add") {
            $this->addRecipe();
        } else if (($this->_url) == "recipe_edit") {
            $idRecipe = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idRecipe)) {
                $this->modifyRecipe($idRecipe);
            }
        }
    }

    private function recipes()
    {
        $this->recipeDAO = new RecipeDAO();
        $recipes = $this->recipeDAO->getRecipes();
        $this->_view = new View($this->_url);
        $this->_data = ['recipes' => $recipes, 'url' => $this->_url, "title" => "Recipes"];
    }


    private function modifyRecipe($idRecipe)
    {
        $this->recipeDAO = new RecipeDAO();
        $recipe = $this->recipeDAO->getRecipe($idRecipe);
        $paragraphs = $this->recipeDAO->getParagraphs($idRecipe);
        $ingredients = $this->recipeDAO->getIngredients($idRecipe);
        $listAllIngredients = $this->recipeDAO->getAllIngredients();
        $this->_view = new View($this->_url);
        $this->_data = ['recipe' => $recipe, 'paragraphs' => $paragraphs, 'ingredients' => $ingredients, 'listAllIngredients' => $listAllIngredients, 'url' => $this->_url, "title" => "Recipes"];
    }

    private function addRecipe(){
        $this->recipeDAO = new RecipeDAO();
        $listAllIngredients = $this->recipeDAO->getAllIngredients();
        $this->_view = new View($this->_url);
        $this->_data = ['listAllIngredients' => $listAllIngredients, 'url' => $this->_url, "title" => "Recipes"];
    }
}
