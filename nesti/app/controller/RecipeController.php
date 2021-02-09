<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/recipe.php');

class RecipeController extends BaseController
{
    private $recipeDAO;

    public function initialize()
    {
        if (($this->_url) == "recipe" || ($this->_url) == "recipe_add") {
            $this->recipes();
        } else {
            $idRecipe = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idRecipe)) {
                $this->recipe($idRecipe);
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
    private function recipe($idRecipe)
    {
        $this->recipeDAO = new RecipeDAO();
        $recipe = $this->recipeDAO->getRecipe($idRecipe);
        $paragraphs = $this->recipeDAO->getParagraphs($idRecipe);
        $ingredients = $this->recipeDAO->getIngredients($idRecipe);
        echo sizeof($ingredients);
        $this->_view = new View($this->_url);
        $this->_data = ['recipe' => $recipe, 'paragraphs' => $paragraphs,'ingredients' => $ingredients, 'url' => $this->_url, "title" => "Recipes"];
    }

    
}
