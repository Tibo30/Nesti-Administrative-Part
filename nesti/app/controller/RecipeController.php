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
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                $data = $this->addRecipeAllIngredients();
                $this->addRecipeDatabase();
            }
        } else if (($this->_url) == "recipe_edit") {
            $idRecipe = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            if (isset($idRecipe)) {
                $data =  $this->modifyRecipe($idRecipe);
            }
        } else if (($this->_url) == "recipe_addingredient") {
            $this->addIngredient(); // this is the method called by the fetch API with the recipe/addingredient ROOT.
        } else if (($this->_url) == "recipe_deleteingredient") {
            $this->deleteIngredient(); // this is the method called by the fetch API with the recipe/deleteingredient ROOT.
        } else if (($this->_url) == "recipe_addpicture") {
            $this->addPicture(); // this is the method called by the fetch API with the recipe/addpicture ROOT.
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
        $data['success'] = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
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
            if ($RecipeNameError == "" && $DifficultyError == "" && $NumberOfPeopleError == "" && $PreparationTimeError == "") {
                $idRecipe = $this->recipeDAO->addRecipe($recipeAdd);
                $recipeAdd->setIdRecipe($idRecipe);
                $data['recipeAdd'] = $recipeAdd;
                $data['idRecipe'] = $recipeAdd->getIdRecipe();
                $data['nameRecipe'] = $recipeAdd->getRecipeName();
                $data['difficultyRecipe'] = $recipeAdd->getDifficulty();
                $data['numberPeopleRecipe'] = $recipeAdd->getNumberOfPeople();
                $data['timeRecipe'] = $recipeAdd->getTime();
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
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
            if ($recipeIngredients != null) {
                $lastOrder = $recipeIngredients[count($recipeIngredients) - 1]->getOrder(); // we get the last order of the recipe ingredient for this recipe
            } else {
                $lastOrder = 0;
            }

            $ingredientDAO = new IngredientDAO();
            $ingredient = new Product();
            $nameIngredient = filter_input(INPUT_POST, "name_ingredient", FILTER_SANITIZE_STRING); // we get the name of the ingredient
            $ingredient = $ingredientDAO->getIngredientByName($nameIngredient); // we check if the ingredient already exist
            $productNameError = "";
            if ($ingredient->getIdProduct() == null) { // if not we create it
                $productNameError = $ingredient->setProductName($nameIngredient);
                if ($productNameError == "") {
                    $ingredientId = $ingredientDAO->createProductIngredient($nameIngredient);
                }
                $ingredient->setIdProduct($ingredientId);
            }

            $unitDAO = new UnitMeasureDAO();
            $unit = new UnitMeasure();
            $unitName = filter_input(INPUT_POST, "unit_ingredient", FILTER_SANITIZE_STRING); // we get the name of the unit measure
            $unit = $unitDAO->getUnitMeasureByName($unitName); // we check if the unit measure already exist
            $unitNameError = "";
            if ($unit->getIdUnitMeasure() == null) { // if the unit measure doesn't exist in the database, we create it
                $unitNameError = $unit->setName($unitName);
                if ($unitNameError == "") {
                    $unitId = $unitDAO->createUnitMeasure($unitName);
                }
                $unit->setIdUnitMeasure($unitId);
            }

            $quantity = filter_input(INPUT_POST, "quantity_ingredient", FILTER_SANITIZE_STRING); // we get the quantity
            // we create the new object recipe ingredients
            $recipeIngredient = new RecipeIngredients();
            $quantityError = $recipeIngredient->setQuantity($quantity);
            $recipeIngredient->setOrder($lastOrder + 1);
            $recipeIngredient->setIdRecipe($idRecipe);
            $recipeIngredient->setIDUnitMeasure($unit->getIdUnitMeasure());
            $recipeIngredient->setIDIngredient($ingredient->getIdProduct());

            $errorMessages = ['productName' => $productNameError, 'unitName' => $unitNameError, 'quantity' => $quantityError];
            $data['errorMessages'] = $errorMessages;

            // si bug, remettre null à la place de ""
            // if there is no error
            if ($productNameError == "" && $unitNameError == "" && $quantityError == "") {
                $recipeIngredientsDAO = new RecipeIngredientsDAO();
                $recipeIngredientsDAO->createRecipeIngredient($recipeIngredient);
                $data['recipeIngredient'] = '<div class="d-flex flex-row justify-content-between"><div>' . $quantity . ' ' . $unit->getName() . ' de ' . $ingredient->getProductName() . '</div><div class="btn-delete-ingredient" data-idingredient="' . $recipeIngredient->getIDIngredient() . '" data-idrecipe="' . $recipeIngredient->getIdRecipe() . '" data-order="' . $recipeIngredient->getOrder() . '">delete</div></div>';
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to delete an ingredient from a recipe
     */
    private function deleteIngredient()
    {
        $data = [];
        $data['success'] = false;

        if (isset($_POST) && !empty($_POST)) {
            $idRecipe = filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING); // first we get the id of the recipe
            $idIngredient = filter_input(INPUT_POST, "id_ingredient", FILTER_SANITIZE_STRING); // then we get the id of the ingredient
            $order = filter_input(INPUT_POST, "order", FILTER_SANITIZE_STRING); // then we get the order of the ingredient

            $recipeIngredientDAO = new RecipeIngredientsDAO();
            $recipeIngredientDAO->deleteRecipeIngredient($idRecipe, $idIngredient, $order);

            $recipeIngredients = $recipeIngredientDAO->getRecipeIngredients($idRecipe); // we get all the remaining recipe ingredients for this recipe

            if ($recipeIngredients != null) {
                $index = 0;
                $newOrder = 1;
                foreach ($recipeIngredients as $recipeIngredient) {
                    if ($recipeIngredient->getOrder() != $newOrder) {
                        $recipeIngredientDAO->editRecipeIngredient($recipeIngredient->getIdRecipe(), $recipeIngredient->getIDIngredient(), $recipeIngredient->getOrder(), $newOrder);
                        $recipeIngredient->setOrder($newOrder);
                    }
                    $data['recipeIngredient'][$index]['all'] = '<div class="d-flex flex-row justify-content-between"><div>' . $recipeIngredient->getQuantity() . ' ' . $recipeIngredient->getUnitMeasure()->getName() . ' de ' . $recipeIngredient->getIngredient()->getProductName() . '</div><div class="btn-delete-ingredient" data-idingredient="' . $recipeIngredient->getIDIngredient() . '" data-idrecipe="' . $recipeIngredient->getIdRecipe() . '" data-order="' . $recipeIngredient->getOrder() . '">delete</div></div>';
                    $index++;
                    $newOrder++;
                }
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to add Picture of a recipe
     */
    private function addPicture()
    {
        $data = [];

        if (isset($_FILES) && !empty($_FILES)) {
            $data = [];
            $data['success'] = false;

            $pictureDAO = new PictureDAO;

            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // we define the accepted extensions


            $img = $_FILES['image']['name']; // this is the file name
            $tmp = $_FILES['image']['tmp_name']; // this is the file temporary name

            $path = BASE_DIR . "/public/pictures/pictures/" . strtolower($img); // this is the path that we want for the picture
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION)); // get the extension name of the file
            $position = strrpos($img, "."); // get the position of the "." in the file name

            $data['download'] = is_uploaded_file($tmp = $_FILES['image']['tmp_name']);

            if (in_array($ext, $valid_extensions)) { // if the extension is valid    
                $iD = $_POST['id_recipe'];
                $picture = new Picture();
                $picture->setExtension($ext);
                $picture->setName(substr($img, 0, $position));
                if (($pictureDAO->doesPictureExist($picture->getName(), $picture->getExtension())) == false) { // check if the picture/name is not already in the table
                    if (move_uploaded_file($tmp, $path)) { // move the file form temporary folder to right folder (according to path)
                        $data['success'] = true;
                        $idPicture = $pictureDAO->insertPicture($picture, $iD); // insert the picture in the DAO et get the ID back
                        $picture->setIdPicture($idPicture);
                        $recipe = $this->recipeDAO->getRecipe($iD); // get the article from the DAO
                        $recipe->setIdPicture($idPicture); // set the idPicture to the object
                        $this->recipeDAO->editRecipe($recipe, "picture"); // edit the article in the database with the new picture
                    } else {
                        $data['errorMove'] = "The picture has not been added";
                    }
                } else { // the name is already in the database
                    $data['success'] = true;
                    $picture = $pictureDAO->getPictureByName($picture->getName(), $picture->getExtension()); // get the picture from the database
                    $recipe = $this->recipeDAO->getRecipe($iD); // get the article from the DAO
                    $recipe->setIdPicture($picture->getIdPicture()); // set the id picture of the article
                    $this->recipeDAO->editRecipe($recipe, "picture"); // edit the article in the database with this picture
                    $data['MessageDb'] = "The name is already taken in the database. The picture added is the one from the database. Change the name of your picture if you want this one to be added";
                }

                $data["picture"] = $picture->getName() . "." . $picture->getExtension();
                $data["urlPicture"] = BASE_URL . PATH_PICTURES . $data["picture"];
            }
        }
        echo json_encode($data);
        die;
    }
}
