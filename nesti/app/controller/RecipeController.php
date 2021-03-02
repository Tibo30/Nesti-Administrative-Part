<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/recipe.php');

class RecipeController extends BaseController
{
    private $recipeDAO;

    public function initialize()
    {
        $data[] = null;
        $this->recipeDAO = new RecipeDAO();
        if (($this->_url) == "recipe") {
            $data = $this->recipes();
        } else if (($this->_url) == "recipe_add") {
            if (isset($_POST) && !empty($_POST)) {
                $data = $this->addRecipeAllIngredients();
                $data = array_merge($data,$this->addRecipeDatabase());
            }
        } else if (($this->_url) == "recipe_edit") {
            $idRecipe = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idRecipe)) {
                $data =  $this->modifyRecipe($idRecipe);
            }
        }
        $data["title"] = "Recipes";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
    }

    private function recipes()
    {
        $recipes = $this->recipeDAO->getRecipes();
        $data = ['recipes' => $recipes];
        return $data;
    }


    private function modifyRecipe($idRecipe)
    {
        $recipe = $this->recipeDAO->getRecipe($idRecipe);
        $paragraphs = $this->recipeDAO->getParagraphs($idRecipe);
        $ingredients = $this->recipeDAO->getIngredients($idRecipe);
        $listAllIngredients = $this->recipeDAO->getAllIngredients();
        $data = ['recipe' => $recipe, 'paragraphs' => $paragraphs, 'ingredients' => $ingredients, 'listAllIngredients' => $listAllIngredients];
        return $data;
    }

    private function addRecipeAllIngredients()
    {
        $listAllIngredients = $this->recipeDAO->getAllIngredients();
        $data = ['listAllIngredients' => $listAllIngredients];
        return $data;
    }

    public function addRecipeDatabase()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            var_dump($_POST);
            $recipeName = filter_input(INPUT_POST, "recipeName", FILTER_SANITIZE_STRING);
            $difficulty = filter_input(INPUT_POST, "difficulty", FILTER_SANITIZE_STRING);
            $numberOfPeople = filter_input(INPUT_POST, "numberOfPeople", FILTER_SANITIZE_STRING);
            $preparationTime = filter_input(INPUT_POST, "preparationTime", FILTER_SANITIZE_STRING);

            $recipeAdd = new Recipe();
            $RecipeNameError = $recipeAdd->setRecipeName($recipeName);
            $DifficultyError = $recipeAdd->setDifficulty($difficulty);
            $NumberOfPeopleError = $recipeAdd->setNumberOfPeople($numberOfPeople);
            $PreparationTimeError =  $recipeAdd->setTime($preparationTime);
            $errorMessages=['recipeName'=>$RecipeNameError,'difficulty'=>$DifficultyError,'numberOfPeople'=>$NumberOfPeopleError,'preparationTime'=>$PreparationTimeError];
            $data['errorMessages']= $errorMessages;

            // if all the datas inputed are correct, we do the query
            if ($RecipeNameError==null && $DifficultyError==null && $NumberOfPeopleError==null && $PreparationTimeError==null) {
                $this->recipeDAO->addRecipe($recipeAdd);
                $data['recipeAdd']=$recipeAdd;
            }
        }

        return $data;
    }
}
