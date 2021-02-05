<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL.'entities/recipe.php');

class RecipeController extends BaseController
{
    private $recipeDAO;

    public function initialize()
    {
        $this->recipes();
    }

    private function recipes()
    {
        $this->recipeDAO = new RecipeDAO();
        //echo "recipeController / ";
        $recipes = $this->recipeDAO->getRecipes();
        

       // $recipe1 = array('id_recipes' => "1", 'creation_date' => "25/10/1992", 'recipe_name' => "crepes", 'difficulty' => "2", 'number_of_people' => "12", 'state' => "block", 'time' => "2h", 'id_pictures' => "2", 'id_chief'=>"3");
       // $recipe2 = array('id_recipes' => "2", 'creation_date' => "21/10/2000", 'recipe_name' => "gateaux", 'difficulty' => "3", 'number_of_people' => "2", 'state' => "unblock", 'time' => "1h", 'id_pictures' => "1", 'id_chief'=>"4");

        //$recipes = array($recipe1,$recipe2);
        $this->_view = new View($this->_url);
        $this->_data = ['recipes' => $recipes, 'url' => $this->_url, "title" => "Recipes"];
    }
}

