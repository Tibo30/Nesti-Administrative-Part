<?php
if (!isset($recipeAdd) || empty($recipeAdd)) {
    $recipeAdd = new Recipe();
}
if (!isset($errorMessages) || empty($errorMessages)) {
    $errorMessages = [];
}
if (!isset($listAllIngredients)) {
    $listAllIngredients = [];
    if (!empty($listAllIngredients)) {
        foreach ($listAllIngredients as $ingredients) {
            $ingredients = new Ingredients();
        }
    }
}

?>
<div class="container bg-white align-items-left" id="recipeAddPage">
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
                    <label for="inputAddRecipeName">Recipe name</label>
                    <input type="text" class="form-control p-0" id="inputAddRecipeName" name="recipeName" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                    <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                        <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                    <?php endif; ?>
                    <small id="recipeAddChiefName" class="form-text text-muted">Recipe Chief : <?= $_SESSION["lastname"] . " " . $_SESSION["firstname"] ?></small>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputAddDifficulty">Difficulty (grade on 5)</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputAddDifficulty" name="difficulty" value="<?php echo !empty($recipeAdd->getDifficulty()) ? $recipeAdd->getDifficulty() : ''; ?>"></div>
                    <?php if (array_key_exists('difficulty', $errorMessages)) : ?>
                        <span class="text-danger"><?php echo $errorMessages['difficulty']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputAddNumberOfPeople">Number of people</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputAddNumberOfPeople" name="numberOfPeople" value="<?php echo !empty($recipeAdd->getNumberOfPeople()) ? $recipeAdd->getNumberOfPeople() : ''; ?>"></div>
                    <?php if (array_key_exists('numberOfPeople', $errorMessages)) : ?>
                        <span class="text-danger"><?php echo $errorMessages['numberOfPeople']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputAddPreparationTime">Preparation time in minutes</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputAddPreparationTime" name="preparationTime" value="<?php echo !empty($recipeAdd->getTime()) ? $recipeAdd->getTime() : ''; ?>"></div>
                </div>
                <?php if (array_key_exists('preparationTime', $errorMessages)) : ?>
                    <span class="text-danger"><?php echo $errorMessages['preparationTime']; ?></span>
                <?php endif; ?>
                <div class="d-flex flex-row">
                    <button id="submitNewRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelNewRecipe" type="reset" class="btn">Cancel</button>
                </div>
            </form>

        </div>
        <div>
            <div id="pictureAddRecipe" class="bg-light border mb-2"></div>
            <div class="mb-3" style="width:80%;margin-left: 3.5em">
                <label for="recipeImgUpload" style="width:50%">Add a picture :</label>
                <div>
                    <input id="recipeImgUpload" class="border border-info rounded" type='file' accept=".png, .jpg, .jpeg" name="recipe_name" style="width:100%;">
                </div>
            </div>
        </div>
    </div>

    <!-- changer le 2eme visible to invisible  -->
    <div class="container px-0 mx-0 mt-3 bg-light d-flex flex-row justify-content-between <?= (!empty($recipeAdd->getRecipeName()) && !empty($recipeAdd->getDifficulty()) && !empty($recipeAdd->getNumberOfPeople()) && !empty($recipeAdd->getTime())) ? 'visible' : 'visible'; ?>" id="hiddenContentAddRecipe">
        <div class="col-7">
            <h3 class="mb-2 mt-2">Preparation</h3>
            <div class="form-group">
                <div id="paragraphesAddRecipe" class="d-flex flex-column"></div>
                <button id="addParagraphNewRecipe" class="btn">
                    <div class="fas fa-plus"></div>
                </button>
            </div>
        </div>
        <div class="col-4">
            <h3 class="mb-2 mt-2">Ingredient List</h3>
            <div class="form-group">
                <div id="addIngredientListAddRecipe" class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                </div>
                <div class="col-12 p-0 mb-3">
                    <label for="inputIngredientNameAddRecipe">Add an ingredient</label>
                    <input list="ingredientsAdd" type="text" class="form-control p-0" id="inputIngredientNameAddRecipe">
                    <datalist id="ingredientsAddListAddRecipe">
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

<script>
    const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS?>';
    var addParagraph = document.querySelector("#addParagraphNewRecipe");
    var index = 0;
    if (addParagraph != null) {
        addParagraph.addEventListener('click', function() {
            index++;
            var paragraphArea = document.querySelector("#paragraphesAddRecipe");
            paragraphArea.innerHTML += '<div class = "paragraphAddRecipeLine d-flex flex-row flex-wrap justify-content-between" data-id="' + index + '"></div>';
            var paragrapheLines = document.querySelectorAll(".paragraphAddRecipeLine");
            for (i = 0; i < paragrapheLines.length; i++) {
                const id = paragrapheLines[i].getAttribute('data-id');
                if (i == 0) { // if this is the first paragraph
                    if (paragrapheLines.length > 1){ // if there is more than 1 paragraph
                        paragrapheLines[i].innerHTML = '<div class="paragraphIcons"><img src="' + ROOT_ICONS + 'down-svg.png" class="downSvg" alt= "arrow down icon"><img src="' + ROOT_ICONS + 'delete-svg.png" class="deleteSvg" alt= "delete icon"></div><textarea class="form-control mb-2 paragraphAddRecipe" data-id="' + index + '" rows="5" style="resize: none;"></textarea>';
                    } else { // if there is only 1 paragraph
                        paragrapheLines[i].innerHTML = '<div class="paragraphIcons"><img src="' + ROOT_ICONS + 'delete-svg.png" class="deleteSvg" alt= "delete icon"></div><textarea class="form-control mb-2 paragraphAddRecipe" data-id="' + index + '" rows="5" style="resize: none;"></textarea>';
                    }
                } else if (i==paragrapheLines.length-1 && paragrapheLines.length>1){ // if this is the last paragraph and there is more than one
                    paragrapheLines[i].innerHTML = '<div class="paragraphIcons"><img src="' + ROOT_ICONS + 'up-svg.png" class="upSvg" alt= "arrow up icon"><img src="' + ROOT_ICONS + 'delete-svg.png" class="deleteSvg" alt= "delete icon"></div><textarea class="form-control mb-2 paragraphAddRecipe" data-id="' + index + '" rows="5" style="resize: none;"></textarea>';
                } else {
                    paragrapheLines[i].innerHTML = '<div class="paragraphIcons"><img src="' + ROOT_ICONS + 'up-svg.png" class="upSvg" alt= "arrow up icon"><img src="' + ROOT_ICONS + 'down-svg.png" class="downSvg" alt= "arrow down icon"><img src="' + ROOT_ICONS + 'delete-svg.png" class="deleteSvg"class="downSvg" alt= "delete icon"></div><textarea class="form-control mb-2 paragraphAddRecipe" data-id="' + index + '" rows="5" style="resize: none;"></textarea>';
                }
            }
        });
    }
</script>