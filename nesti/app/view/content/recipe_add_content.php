<div class="container bg-white align-items-left" id="recipePage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>recipe"><u>Recipes</u>
        </a>
        <p> &nbsp > Create</p>
    </div>
    <div class="d-flex flex-row justify-content-around">
        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">Recipe Creation</h2>
            <form method="post">
                <div class="form-group">
                    <label for="inputRecipeName">Recipe name</label>
                    <input type="text" class="form-control p-0" id="inputRecipeName" name="recipeName" value="<?php echo !empty($_POST['recipeName']) ? $_POST['recipeName'] : ''; ?>">
                    <small id="recipeChiefName" class="form-text text-muted">Recipe Chief : <?= $_SESSION["lastname"] . " " . $_SESSION["firstname"] ?></small>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputDifficulty">Difficulty (grade on 5)</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputDifficulty" name="difficulty" value="<?php echo !empty($_POST['difficulty']) ? $_POST['difficulty'] : ''; ?>"></div>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputNumberOfPeople">Number of people</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputNumberOfPeople" name="numberOfPeople" value="<?php echo !empty($_POST['numberOfPeople']) ? $_POST['numberOfPeople'] : ''; ?>"></div>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputPreparationTime">Preparation time in minutes</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputPreparationTime" name="preparationTime" value="<?php echo !empty($_POST['preparationTime']) ? $_POST['preparationTime'] : ''; ?>"></div>
                </div>
                <div class="d-flex flex-row">
                    <button id="submitNewRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelNewRecipe" type="reset" class="btn">Cancel</button>
                </div>
            </form>

        </div>
        <div>
            <div id="pictureAdd" class="bg-light border mb-2"></div>
            <label class="form-label" for="customFile">Download a new picture</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="InputFile">
                <label class="custom-file-label" for="InputFile" data-browse="Browse"></label>
            </div>

        </div>
    </div>

    <div class="container px-0 mx-0 mt-3 bg-light d-flex flex-row justify-content-between <?= (isset($_POST) && !empty($_POST)) ? 'visible' : 'invisible'; ?>" id="hiddenContentAddRecipe">
        <div class="col-7">
            <h3 class="mb-2 mt-2">Preparation</h3>
            <div class="form-group">
                <div></div>
                <button id="addParagraphNewRecipe" class="btn">
                    <div class="fas fa-plus"></div>
                </button>
            </div>
        </div>
        <div class="col-4">
            <h3 class="mb-2 mt-2">Ingredient List</h3>
            <div class="form-group">
                <div id="addIngredientList" class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                </div>
                <div class="col-12 p-0 mb-3">
                    <label for="inputIngredientNameAddRecipe">Add an ingredient</label>
                    <input list="ingredientsAdd" type="text" class="form-control p-0" id="inputIngredientNameAddRecipe">
                    <datalist id="ingredientsAdd">
                        <?php
                        foreach ($listAllIngredients as $ingredients) {
                            echo '<option value="' . ($ingredients->getProductName()) . '">';
                        }
                        ?>
                    </datalist>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <div class="col-4 p-0"><input type="text" class="form-control" placeholder="Quantity"></div>
                    <div class="col-2 p-0"><input type="text" class="form-control" placeholder="Unit of Measure"></div>
                    <button id="okRecipeAdd" type="submit" class="btn mr-5">ok</button>
                </div>
            </div>
        </div>
    </div>
</div>