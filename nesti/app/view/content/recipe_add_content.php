<?php
if (!isset($listAllIngredients)) {
    $listAllIngredients = [];
    if (!empty($listAllIngredients)) {
        foreach ($listAllIngredients as $ingredient) {
            $ingredient = new Ingredients();
        }
    }
}
if (!isset($listAllUnits)) {
    $listAllUnits = [];
    if (!empty($listAllUnits)) {
        foreach ($listAllUnits as $unit) {
            $unit = new UnitMeasure();
        }
    }
}
?>
    <div class="container bg-white align-items-left position-relative" id="recipeAddPage">
        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>recipe"><u>Recipes</u>
            </a>
            <p> &nbsp; > Create</p>
        </div>
        <h2 class="mb-2 mt-2">Recipe Creation</h2>

        <!-- div notif recipe created -->
        <div id="recipeCreatedSuccess" class="notifications" hidden>
            <p>The recipe has been successfully created </p>
        </div>
        <!-- div notif picture added -->
        <div id="recipePictureAddSuccess" class="notifications" hidden>
            <p>The picture has been successfully added </p>
        </div>
        <!-- div notif picture added but same name -->
        <div id="recipePictureAddInfo" class="notifications" hidden>
            <p> </p>
        </div>
        <!-- div notif picture error-->
        <div id="recipePictureAddError" class="notifications" hidden>
            <p> </p>
        </div>

        <div class="d-flex flex-row flex-wrap justify-content-around">
            <div class="d-flex flex-column">

                <form method="post" id="addRecipeForm">
                    <div class="form-group">
                        <label for="inputAddRecipeName">Recipe name</label>
                        <input type="text" class="form-control" id="inputAddRecipeName" name="recipeName" value="">
                        <small id="recipeAddChiefName" class="form-text text-muted">Recipe Chief : <?= $_SESSION["lastname"] . " " . $_SESSION["firstname"] ?></small>
                    </div>
                    <span class="text-danger" id="errorRecipeName"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputAddDifficulty">Difficulty (grade on 5)</label>
                        <div class="col-2 p-0"><input type="text" class="form-control" id="inputAddDifficulty" name="difficulty" value=""></div>
                    </div>
                    <span class="text-danger" id="errorDifficulty"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputAddNumberOfPeople">Number of people</label>
                        <div class="col-2 p-0"><input type="text" class="form-control" id="inputAddNumberOfPeople" name="numberOfPeople" value=""></div>
                    </div>
                    <span class="text-danger" id="errorNumberPeople"></span>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputAddPreparationTime">Preparation time in minutes</label>
                        <div class="col-2 p-0"><input type="text" class="form-control" id="inputAddPreparationTime" name="preparationTime" value=""></div>
                    </div>
                    <span class="text-danger" id="errorTime"></span>
                    <div class="d-flex flex-row justify-content-center">
                        <button id="submitNewRecipe" type="submit" class="btn mr-5">Submit</button>
                        <button id="cancelNewRecipe" type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <input type="text" class="form-control" name="idRecipe" id="idRecipe" value="" hidden>
            </div>


            <div class="invisible mt-3 mt-xl-0" id="addPicture">
                <div id="recipePictureAdd" class="bg-light border mb-2"></div>
                <div class=" d-flex flex-row justify-content-between">
                    <p class="recipePictureAddName"></p>
                </div>
                <label class="form-label" for="InputFileAddRecipe">Download a new picture</label>

                <div class="custom-file">
                    <form id="formAddRecipeImage" enctype="multipart/form-data" method="post">
                        <div class="d-flex flex-column">
                            <input type="file" class="custom-file-input" id="InputFileAddRecipe" name="image" accept="image/png, image/jpeg, image/jpg" onchange="updatePictureName()">
                            <div class="d-flex align-items-center justify-content-end">
                                <p class="pictureNameInput w-100"></p>
                                <button type="submit" class="align-self-end mt-1 btn" id="btn-add-recipe-picture">OK</button>
                            </div>
                        </div>
                        <label class="custom-file-label" for="InputFileAddRecipe" data-browse="Browse"></label>
                    </form>
                </div>
            </div>
            <!-- div notif paragraph deleted -->
            <div id="recipeParagraphDeletedSuccess" class="notifications" hidden>
                <p>The paragraph has been successfully deleted from the recipe. Please don't forget to save ! </p>
            </div>
            <!-- div notif paragraph moved-->
            <div id="recipeParagraphMovedSuccess" class="notifications" hidden>
                <p>Please don't forget to save ! </p>
            </div>
            <!-- div notif paragraph saved-->
            <div id="recipeParagraphSavedSuccess" class="notifications" hidden>
                <p>The paragraphs have been saved in the database </p>
            </div>
            <!-- div notif ingredient added -->
            <div id="recipeIngredientAddSuccess" class="notifications" hidden>
                <p>The ingredient has been successfully added to the recipe </p>
            </div>
            <!-- div notif ingredient deleted -->
            <div id="recipeIngredientDeletedSuccess" class="notifications" hidden>
                <p>The ingredient has been successfully deleted from the recipe </p>
            </div>
        </div>


        <div class="container px-0 mx-0 mt-5 bg-light d-flex flex-row flex-wrap justify-content-between invisible position-relative" id="hiddenContentAddRecipe">
            <div class="col-12 col-lg-7">
                <h3 class="mb-2 mt-2">Preparation</h3>
                <div class="form-group">
                    <div id="paragraphsAddRecipe" class="d-flex flex-column"></div>
                    <div class="d-flex flex-column align-items-center">
                        <button id="addParagraphNewRecipe" class="btn" onclick="addParagraph()">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button id="okParagraphAddRecipe" type="submit" class="btn">SAVE</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <h3 class="mb-2 mt-2">Ingredient List</h3>
                <div class="form-group">
                    <div id="addIngredientListAddRecipe" class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                    </div>
                    <div class="col-12 p-0 mb-3">

                        <label for="inputIngredientNameAddRecipe">Add an ingredient</label>
                        <input list="ingredientsAdd" type="text" class="form-control" placeholder="Ingredient" id="inputIngredientNameAddRecipe" name="ingredient">
                        <datalist id="ingredientsAdd">
                            <?php
                            foreach ($listAllIngredients as $ingredients) {
                                echo '<option value="' . ($ingredients->getProductName()) . '">';
                            }
                            ?>
                        </datalist>
                        <span class="text-danger" id="errorRecipeAddIngredient"></span>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <div class="col-4 p-0"><input type="text" class="form-control" placeholder="Quantity" name="quantity" id="inputIngredientQuantityAddRecipe"></div>
                        <div class="col-5 p-0">
                            <input list="UnitsAdd" type="text" class="form-control" placeholder="Unit of Measure" name="unitMeasure" id="inputIngredientUnitAddRecipe">
                            <datalist id="UnitsAdd">
                                <?php
                                foreach ($listAllUnits as $unit) {
                                    echo '<option value="' . ($unit->getName()) . '">';
                                }
                                ?>
                            </datalist>
                        </div>
                        <button id="okIngredientAddRecipe" type="submit" class="btn">OK</button>
                        <span class="text-danger" id="errorRecipeAddQuantity"></span>
                        <span class="text-danger" id="errorRecipeAddUnit"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
        const ROOT = '<?= BASE_URL ?>';
    </script>