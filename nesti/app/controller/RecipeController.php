<?php
require_once(BASE_DIR . PATH_VIEW . 'View.php');

class RecipeController extends BaseController
{
    private $recipeDAO;

    /**
     * initialize the controller
     */
    public function initialize()
    {
        if (array_search("chief", $_SESSION["roles"]) !== false || array_search("admin", $_SESSION["roles"]) !== false) {
            $data[] = null;
            $this->recipeDAO = new RecipeDAO();
            if (($this->_url) == "recipe") {
                $data = $this->recipes();
                $data["title"] = "Recipes";
                $data["url"] = $this->_url;
                $this->_view = new View($this->_url);
                $this->_data = $data;
            } else if (($this->_url) == "recipe_add") {
                if (array_search("chief", $_SESSION["roles"]) !== false) {
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                        $this->addRecipeDatabase(); // this is the method called by the fetch API with the recipe/add ROOT.
                    }
                    $data = $this->addRecipeAllIngredients();
                    $data["title"] = "Recipes";
                    $data["url"] = $this->_url;
                    $this->_view = new View($this->_url);
                    $this->_data = $data;
                } else {
                    $this->_view = new View("norights");
                }
            } else if (($this->_url) == "recipe_edit") {
                $idRecipe = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
                if (isset($idRecipe)) {
                    $data =  $this->getThisRecipe($idRecipe);
                }
                // Only administrator or the chief that wrote the recipe can edit it.
                if (array_search("admin", $_SESSION["roles"]) !== false || $data["recipe"]->getChief()->getIdUser() == $_SESSION["idUser"]) {
                    $data["title"] = "Recipes";
                    $data["url"] = $this->_url;
                    $this->_view = new View($this->_url);
                    $this->_data = $data;
                } else {
                    $this->_view = new View("norights");
                }
            } else if (($this->_url) == "recipe_addingredient") {
                $this->addIngredient(); // this is the method called by the fetch API with the recipe/addingredient ROOT.
            } else if (($this->_url) == "recipe_deleteingredient") {
                $this->deleteIngredient(); // this is the method called by the fetch API with the recipe/deleteingredient ROOT.
            } else if (($this->_url) == "recipe_addpicture") {
                $this->addPicture(); // this is the method called by the fetch API with the recipe/addpicture ROOT.
            } else if (($this->_url) == "recipe_saveparagraph") {
                $this->saveParagraph(); // this is the method called by the fetch API with the recipe/saveparagraph ROOT.
            } else if (($this->_url) == "recipe_deleteparagraph") {
                $this->deleteParagraph(); // this is the method called by the fetch API with the recipe/deleteparagraph ROOT.
            } else if (($this->_url) == "recipe_editrecipe") {
                $this->editRecipeDatabase(); // this is the method called by the fetch API with the recipe/editrecipe ROOT.
            } else if (($this->_url) == "recipe_editpicture") {
                $this->addPicture(); // this is the method called by the fetch API with the recipe/editpicture ROOT.
            } else if (($this->_url) == "recipe_deletepicture") {
                $this->deletePictureRecipe(); // this is the method called by the fetch API with the recipe/deletepicture ROOT.
            } else if (($this->_url) == "recipe_editaddingredient") {
                $this->addIngredient(); // this is the method called by the fetch API with the recipe/editaddingredient ROOT.
            } else if (($this->_url) == "recipe_editdeleteingredient") {
                $this->deleteIngredient(); // this is the method called by the fetch API with the recipe/editdeleteingredient ROOT.
            } else if (($this->_url) == "recipe_delete") {
                $this->deleteRecipe(); // this is the method called by the fetch API with the recipe/delete ROOT.
            }
        } else {
            $this->_view = new View("norights");
        }
    }

    /**
     * Get all recipes
     */
    private function recipes()
    {
        $recipes = $this->recipeDAO->getRecipes();
        $data = ['recipes' => $recipes];
        return $data;
    }

    /**
     * Get the recipe according to its ID
     * int $idRecipe
     */
    private function getThisRecipe($idRecipe)
    {
        $recipe = $this->recipeDAO->getRecipe($idRecipe); // get the recipe

        $recipeIngredientDAO = new RecipeIngredientsDAO();
        $recipeIngredients = $recipeIngredientDAO->getRecipeIngredients($idRecipe); // get all the ingredients for this recipe

        $listAllIngredients = $this->recipeDAO->getAllIngredients(); // get all the ingredients from the Database

        $unitDAO = new UnitMeasureDAO();
        $listAllUnits = $unitDAO->getUnits(); // get all the units from the Database

        $data = ['recipe' => $recipe, 'recipeIngredients' => $recipeIngredients, 'listAllIngredients' => $listAllIngredients, 'listAllUnits' => $listAllUnits];
        return $data;
    }

    /**
     * Get all the ingredients (for datalist)
     */
    private function addRecipeAllIngredients()
    {
        $listAllIngredients = $this->recipeDAO->getAllIngredients();
        $unitDAO = new UnitMeasureDAO();
        $listAllUnits = $unitDAO->getUnits();
        $data = ['listAllIngredients' => $listAllIngredients, 'listAllUnits' => $listAllUnits];
        return $data;
    }

    /**
     * this is the Ajax method to add a recipe in the database
     */
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
            $recipeAdd->setIdChief($_SESSION["idUser"]);
            $ChiefError = "";
            if ($_SESSION["idUser"] == 0 || $_SESSION["idUser"] == null) {
                $ChiefError = "Error with ID chief";
            }

            if ($this->recipeDAO->recipeDoesExist($recipeName) == true) { // if the name of the recipe is already taken
                $RecipeNameError = "this recipe name already exists. Please choose another one";
            }

            $errorMessages = ['recipeName' => $RecipeNameError, 'difficulty' => $DifficultyError, 'numberOfPeople' => $NumberOfPeopleError, 'preparationTime' => $PreparationTimeError, 'chief' => $ChiefError];
            $data['errorMessages'] = $errorMessages;
            // if all the datas inputed are correct, we do the query
            if ($RecipeNameError == "" && $DifficultyError == "" && $NumberOfPeopleError == "" && $PreparationTimeError == "" && $ChiefError == "") {
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

        if (!empty($_POST)) {
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
                    $ingredient->setIdProduct($ingredientId);
                }
            }

            foreach ($recipeIngredients as $recipeIngredient) { // then we check if this ingredient is already in the recipeIngredients list for this recipe
                if ($recipeIngredient->getIDIngredient() == $ingredient->getIdProduct()) {
                    $productNameError = "This ingredient is already on the list. Please delete it before adding it again";
                }
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
                    $unit->setIdUnitMeasure($unitId);
                }
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
                $data['recipeIngredient'] = '<div class="d-flex flex-row justify-content-between"><div class="mb-3">' . $quantity . ' ' . $unit->getName() . ' of ' . $ingredient->getProductName() . '</div><div onclick="createModalDeleteIngredient(' . $recipeIngredient->getOrder() . ',' . $recipeIngredient->getIdRecipe() . ',' . $recipeIngredient->getIDIngredient() . ')" class="btn-delete-ingredient">delete</div><div id="openModalIngredient' . $recipeIngredient->getOrder() . '" hidden data-toggle="modal" data-target="#modalRecipeDeleteIngredient' . $recipeIngredient->getOrder() . '"></div></div>';
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

        if (!empty($_POST)) {
            $idRecipe = filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING); // first we get the id of the recipe
            $idIngredient = filter_input(INPUT_POST, "id_ingredient", FILTER_SANITIZE_STRING); // then we get the id of the ingredient
            $order = filter_input(INPUT_POST, "order", FILTER_SANITIZE_STRING); // then we get the order of the ingredient

            $recipeIngredientDAO = new RecipeIngredientsDAO();
            $recipeIngredientDAO->deleteRecipeIngredient($idRecipe, $idIngredient, $order);

            $recipeIngredients = $recipeIngredientDAO->getRecipeIngredients($idRecipe); // we get all the remaining recipe ingredients for this recipe
            $data['success'] = true;
            if ($recipeIngredients != null) {
                $index = 0;
                $newOrder = 1;
                foreach ($recipeIngredients as $recipeIngredient) {
                    if ($recipeIngredient->getOrder() != $newOrder) {
                        $recipeIngredientDAO->editRecipeIngredient($recipeIngredient->getIdRecipe(), $recipeIngredient->getIDIngredient(), $recipeIngredient->getOrder(), $newOrder);
                        $recipeIngredient->setOrder($newOrder);
                    }
                    $data['recipeIngredient'][$index]['all'] = '<div class="d-flex flex-row justify-content-between"><div class="mb-3">' . $recipeIngredient->getQuantity() . ' ' . $recipeIngredient->getUnitMeasure()->getName() . ' of ' . $recipeIngredient->getIngredient()->getProductName() . '</div><div onclick="createModalDeleteIngredient(' . $recipeIngredient->getOrder() . ',' . $recipeIngredient->getIdRecipe() . ',' . $recipeIngredient->getIDIngredient() . ')" class="btn-delete-ingredient">delete</div><div id="openModalIngredient' . $recipeIngredient->getOrder() . '" hidden data-toggle="modal" data-target="#modalRecipeDeleteIngredient' . $recipeIngredient->getOrder() . '"></div></div>';
                    $index++;
                    $newOrder++;
                }
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

        if (!empty($_FILES)) {
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
                $picture->setName(substr(strtolower($img), 0, $position));
                if (($pictureDAO->doesPictureExist($picture->getName(), $picture->getExtension())) == false) { // check if the picture/name is not already in the table
                    if (move_uploaded_file($tmp, $path)) { // move the file form temporary folder to right folder (according to path)
                        $data['success'] = true;
                        $idPicture = $pictureDAO->insertPicture($picture); // insert the picture in the DAO and get the ID back
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

    /**
     * this is the Ajax method to delete the Picture of a recipe
     */
    private function deletePictureRecipe()
    {
        $data = [];
        $data['success'] = false;

        if (!empty($_POST)) {
            $idRecipe = $_POST["id_recipe"]; // first we get the id of the recipe
            $recipe = $this->recipeDAO->getRecipe($idRecipe); // then we get the object recipe from the database.
            $recipe->setIdPicture(null);
            $this->recipeDAO->editRecipe($recipe, "picture"); // set the picture to null in the database for this recipe
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to save a paragraph in the database
     */
    public function saveParagraph()
    {
        $data = [];
        $data['success'] = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idRecipe = filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING);
            $idParagraph = filter_input(INPUT_POST, "id_paragraph", FILTER_SANITIZE_STRING);
            $order = filter_input(INPUT_POST, "order_paragraph", FILTER_SANITIZE_STRING);
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_STRING);

            if ($content != "") {
                $data['success'] = true;
                if ($idParagraph == 'null') {
                    $idParagraph = $this->recipeDAO->createParagraph($idRecipe, $order, $content);
                } else {
                    $this->recipeDAO->editParagraph($idRecipe, $idParagraph, $order, $content);
                }
            }

            $data['order'] = $order;
            $data['id_recipe'] = $idRecipe;
            $data['content'] = $content;
            $data['id_paragraph'] = $idParagraph;
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to delete a paragraph in the database
     */
    public function deleteParagraph()
    {
        $data = [];
        $data['success'] = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idParagraph = filter_input(INPUT_POST, "id_paragraph", FILTER_SANITIZE_STRING); // get the id of the paragraph to delete
            $idRecipe = filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING); // get the id of the recipe
            $this->recipeDAO->deleteParagraph($idParagraph); // delete the paragraph from the database

            $paragraphs = $this->recipeDAO->getParagraphs($idRecipe); // we get all the remaining paragraphs for this recipe
            // this loop : if the order of the paragraph in the database is no the same as the order in the list of paragraphs, we update it
            if ($paragraphs != null) {
                $newOrder = 1;
                foreach ($paragraphs as $paragraph) {
                    if ($paragraph->getOrder() != $newOrder) {
                        $this->recipeDAO->editOrderParagraph($idRecipe, $paragraph->getOrder(), $newOrder);
                    }
                    $newOrder++;
                }
            }
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to edit a recipe in the database
     */
    public function editRecipeDatabase()
    {
        $data = [];
        $data['success'] = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idRecipe = filter_input(INPUT_POST, "id_recipe", FILTER_SANITIZE_STRING);
            $recipeName = filter_input(INPUT_POST, "recipeName", FILTER_SANITIZE_STRING);
            $difficulty = filter_input(INPUT_POST, "difficulty", FILTER_SANITIZE_STRING);
            $numberOfPeople = filter_input(INPUT_POST, "numberOfPeople", FILTER_SANITIZE_STRING);
            $preparationTime = filter_input(INPUT_POST, "preparationTime", FILTER_SANITIZE_STRING);
            $recipeState = filter_input(INPUT_POST, "recipeState", FILTER_SANITIZE_STRING);

            $recipeEdit = $this->recipeDAO->getRecipe($idRecipe); // get all the info of the recipe from the database
            $formerRecipeName = $recipeEdit->getRecipeName();
            $formerDifficulty = $recipeEdit->getDifficulty();
            $formerNumberOfPeople = $recipeEdit->getNumberOfPeople();
            $formerPreparationTime = $recipeEdit->getTime();
            $formerRecipeState = $recipeEdit->getState();

            $RecipeNameError = $recipeEdit->setRecipeName($recipeName);
            $DifficultyError = $recipeEdit->setDifficulty($difficulty);
            $NumberOfPeopleError = $recipeEdit->setNumberOfPeople($numberOfPeople);
            $PreparationTimeError =  $recipeEdit->setTime($preparationTime);
            $recipeEdit->setState($recipeState);


            if ($recipeEdit->getRecipeName() != $formerRecipeName && $this->recipeDAO->recipeDoesExist($recipeName) == true) { // if the new name of the recipe is already taken
                $RecipeNameError = "this recipe name already exists. Please choose another one";
            }

            $errorMessages = ['recipeName' => $RecipeNameError, 'difficulty' => $DifficultyError, 'numberOfPeople' => $NumberOfPeopleError, 'preparationTime' => $PreparationTimeError];
            $data['errorMessages'] = $errorMessages;
            // if all the datas inputed are correct, we do the query
            if ($RecipeNameError == "" && $DifficultyError == "" && $NumberOfPeopleError == "" && $PreparationTimeError == "") {
                if ($formerRecipeName != $recipeName) { // if the name changed
                    $this->recipeDAO->editRecipe($recipeEdit, "name");
                }
                if ($formerDifficulty != $difficulty) { // if the difficulty changed
                    $idRecipe = $this->recipeDAO->editRecipe($recipeEdit, "difficulty");
                }
                if ($formerNumberOfPeople != $numberOfPeople) { // if the number of people changed
                    $idRecipe = $this->recipeDAO->editRecipe($recipeEdit, "number");
                }
                if ($formerPreparationTime != $preparationTime) { // if the preparation time changed
                    $idRecipe = $this->recipeDAO->editRecipe($recipeEdit, "time");
                }
                if ($formerRecipeState != $recipeState) { // if the states changed
                    $this->recipeDAO->editRecipe($recipeEdit, "state");
                }

                $data['recipeEdit'] = $recipeEdit;
                $data['idRecipe'] = $recipeEdit->getIdRecipe();
                $data['nameRecipe'] = $recipeEdit->getRecipeName();
                $data['difficultyRecipe'] = $recipeEdit->getDifficulty();
                $data['numberPeopleRecipe'] = $recipeEdit->getNumberOfPeople();
                $data['timeRecipe'] = $recipeEdit->getTime();
                $data['recipeState'] = $recipeEdit->getState();
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to delete a Recipe (change state to Blocked)
     */
    private function deleteRecipe()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idRecipe = $_POST["idRecipe"]; // first we get the id of the recipe
            $recipeEdit = $this->recipeDAO->getRecipe($idRecipe); // we get the recipe from the database
            $recipeEdit->setState("b"); // we change is state in local
            $this->recipeDAO->editRecipe($recipeEdit, "state"); // we change its state in the database
            $data["state"] = $recipeEdit->getDisplayState();
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }
}
