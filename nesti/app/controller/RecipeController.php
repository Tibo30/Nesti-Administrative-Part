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
            if (!empty($_POST)) {
                $data = $this->addRecipeAllIngredients();
                $data = array_merge($data, $this->addRecipeDatabase());
            }
        } else if (($this->_url) == "recipe_edit") {
            $idRecipe = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idRecipe)) {
                $data =  $this->modifyRecipe($idRecipe);
            }
        } else if (($this->_url) == "recipe_addingredient") {
            $this->addIngredient(); // this is the method called by the fetch API with the recipe/addingredient ROOT.
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
        $data = [];
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
            $errorMessages = ['recipeName' => $RecipeNameError, 'difficulty' => $DifficultyError, 'numberOfPeople' => $NumberOfPeopleError, 'preparationTime' => $PreparationTimeError];
            $data['errorMessages'] = $errorMessages;

            // if all the datas inputed are correct, we do the query
            if ($RecipeNameError == null && $DifficultyError == null && $NumberOfPeopleError == null && $PreparationTimeError == null) {
                $idRecipe = $this->recipeDAO->addRecipe($recipeAdd);
                $recipeAdd->setIdRecipe($idRecipe);
                $data['recipeAdd'] = $recipeAdd;
            }
        }
        return $data;
    }

    /**
     * this is the Ajax method to add an ingredient to a recipe
     */
    private function addIngredient()
    {
        $data = [];
        $data['success'] = false;

        if (isset($_POST) && !empty($_POST)) {
            $idRecipe = filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING); // first we get the id of the recipe
            $recipe = $this->recipeDAO->getRecipe($idRecipe);

            $recipeIngredientDAO = new RecipeIngredientsDAO();
            $recipeIngredients = $recipeIngredientDAO->getRecipeIngredients($idRecipe); // we get all the recipe ingredients for this recipe
            if ($recipeIngredients!=null){
                $lastOrder = $recipeIngredients[count($recipeIngredients) - 1]->getOrder(); // we get the last order of the recipe ingredient for this recipe
            } else {
                $lastOrder=0;
            }

            $ingredientDAO = new IngredientDAO();
            $ingredient = new Product();
            $nameIngredient = filter_input(INPUT_POST, "name_ingredient", FILTER_SANITIZE_STRING); // we get the name of the ingredient
            $ingredient = $ingredientDAO->getIngredientByName($nameIngredient); // we check if the ingredient already exist
            $productNameError="";
            if ($ingredient->getIdProduct() == null) { // if not we create it
                $productNameError = $ingredient->setProductName($nameIngredient);
                if ($productNameError==""){
                    $ingredientId = $ingredientDAO->createProductIngredient($nameIngredient);
                }
                $ingredient->setIdProduct($ingredientId);
            }

            $unitDAO = new UnitMeasureDAO();
            $unit = new UnitMeasure();
            $unitName = filter_input(INPUT_POST, "unit_ingredient", FILTER_SANITIZE_STRING); // we get the name of the unit measure
            $unit = $unitDAO->getUnitMeasureByName($unitName); // we check if the unit measure already exist
            $unitNameError="";
            if ($unit->getIdUnitMeasure() == null) { // if the unit measure doesn't exist in the database, we create it
                $unitNameError = $unit->setName($unitName);
                if ($unitNameError==""){
                    $unitId = $unitDAO->createUnitMeasure($unitName);
                }
                $unit->setIdUnitMeasure($unitId);
            }

            $quantity = filter_input(INPUT_POST, "quantity_ingredient", FILTER_SANITIZE_STRING); // we get the quantity
            // we create the new object recipe ingredients
            $recipeIngredient = new RecipeIngredients();
            $quantityError = $recipeIngredient->setQuantity($quantity);
            $recipeIngredient->setOrder($lastOrder+1);
            $recipeIngredient->setIdRecipe($idRecipe);
            $recipeIngredient->setIDUnitMeasure($unit->getIdUnitMeasure());
            $recipeIngredient->setIDIngredient($ingredient->getIdProduct());

            $errorMessages = ['productName' => $productNameError, 'unitName' => $unitNameError, 'quantity' => $quantityError];
            $data['errorMessages']=$errorMessages;
            
            // si bug, remettre null à la place de ""
            // if there is no error
            if ($productNameError=="" && $unitNameError=="" && $quantityError==""){
                $recipeIngredientsDAO= new RecipeIngredientsDAO();
                $recipeIngredientsDAO->createRecipeIngredient($recipeIngredient);
                $data['recipeIngredient']='<div class="d-flex flex-row justify-content-between"><div>'.$quantity.' ' .$unit->getName().' de '.$ingredient->getProductName().'</div><div class="deleteRecipeIngredient" data-order="'.$recipeIngredient->getOrder().'">delete</div></div>';
                $data['success'] = true;
            }

        }
        echo json_encode($data);
        die;
    }
}
