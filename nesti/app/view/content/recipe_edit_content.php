<div class="container bg-white align-items-left" id="recipePage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>recipe"><u>recipes</u>
        </a>
        <p> &nbsp > create</p>
    </div>
    <div class="d-flex flex-row justify-content-around">
        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">Recipe Edit</h2>
            <form>
                <div class="form-group">
                    <label for="inputRecipeName">Recipe name</label>
                    <input type="text" class="form-control p-0" id="inputRecipeName" value="<?= $recipe->getRecipeName() ?>">
                    <small id="recipeChiefName" class="form-text text-muted">Recipe Chief : <?= $recipe->getChief()->getLastname() . " " . $recipe->getChief()->getFirstname() ?></small>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputDifficulty">Difficulty (grade on 5)</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputDifficulty" value="<?= $recipe->getDifficulty() ?>"></div>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputNumberOfPeople">Number of people</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputNumberOfPeople" value="<?= $recipe->getNumberOfPeople() ?>"></div>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputPreparationTime">Preparation time in minutes</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputPreparationTime" value="<?= $recipe->getTime() ?>"></div>
                </div>
                <div class="d-flex flex-row">
                    <button id="submitEditRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelEditRecipe" type="submit" class="btn">Cancel</button>
                </div>

            </form>
        </div>
        <div>
        <div id="pictureEdit" class="bg-light border mb-2"></div>
            <label class="form-label" for="customFile">Download a new picture</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="InputFile">
                <label class="custom-file-label" for="InputFile" data-browse="Browse"></label>
            </div>

        </div>
    </div>

    <div class="container px-0 mx-0 mt-3 bg-light d-flex flex-row justify-content-between">
        <div class="col-7">
            <h3 class="mb-2 mt-2">Preparation</h3>
            <div class="form-group">
                <?php foreach ($paragraphs as $paragraph) {
                    echo '<textarea class="form-control mb-2" id="paragraph1" rows="5" style="resize: none;">' . $paragraph->getContent() . '</textarea>';
                }
                ?>
                <button id="addParagraphEditRecipe" class="btn">
                    <div class="fas fa-plus"></div>
                </button>
            </div>
        </div>
        <div class="col-4">
            <h3 class="mb-2 mt-2">Ingredient List</h3>
            <div class="form-group">
                <textarea class="form-control mb-2" id="list" rows="15" readonly style="resize: none;">
                <?php foreach ($ingredients as $ingredient) {
                    echo strip_tags(' <p> ' . $ingredient->getQuantity() . " " . $ingredient->getUnitMeasure()->getName()." de " . $ingredient->getIngredient()->getProductName() . ' </p><br>');
                }
                ?>
                </textarea>
                <div class="col-12 p-0 mb-3">
                <label for="inputIngredientNameEditRecipe">Add an ingredient</label>
                <input list="ingredientsEdit" type="text" class="form-control p-0" id="inputIngredientNameEditRecipe">
                <datalist id="ingredientsEdit">
                <?php 
                foreach($listAllIngredients as $ingredients){
                    echo '<option value="'.($ingredients->getProductName()).'">' ;
                }
                ?>
                </datalist>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <div class="col-4 p-0"><input type="text" class="form-control" placeholder="Quantity"></div>
                    <div class="col-2 p-0"><input type="text" class="form-control" placeholder="Unit of Measure"></div>
                    <button id="okRecipe" type="submit" class="btn mr-5">ok</button>
                </div>
            </div>
        </div>
    </div>
</div>