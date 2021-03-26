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
    <h2 class="mb-2 mt-2">Recipe Creation</h2>
    <div class="d-flex flex-row justify-content-around">
        <div class="d-flex flex-column">

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
        <!-- changer le 2eme visible to invisible  -->
        <div class="<?= (!empty($recipeAdd->getRecipeName()) && !empty($recipeAdd->getDifficulty()) && !empty($recipeAdd->getNumberOfPeople()) && !empty($recipeAdd->getTime())) ? 'visible' : 'visible'; ?>">
            <div id="recipePictureAdd" class="bg-light border mb-2"></div>
            <div class=" d-flex flex-row justify-content-between">
                <p class="recipePictureAddName"></p>
            </div>
            <label class="form-label" for="customFile">Download a new picture</label>

            <div class="custom-file">
                <form id="formAddRecipeImage" action="" enctype="multipart/form-data" method="post">
                    <div class="d-flex flex-column">
                        <input type="file" class="custom-file-input" id="InputFileAddRecipe" name="image">
                        <!-- le name dans le input se retrouve dans le $_FILES['image'] -->
                        <button type="submit" class="align-self-end mt-1 btn" id="btn-add-recipe-picture">OK</button>
                    </div>
                    <label class="custom-file-label" for="InputFileAddRecipe" data-browse="Browse"></label>
                    <input type="text" class="form-control" name="idRecipePicture" id="idRecipePicture" value="<?= $recipeAdd->getIdRecipe() ?>" hidden>
                </form>
            </div>
        </div>
    </div>

    <!-- changer le 2eme visible to invisible  -->
    <div class="container px-0 mx-0 mt-5 bg-light d-flex flex-row justify-content-between <?= (!empty($recipeAdd->getRecipeName()) && !empty($recipeAdd->getDifficulty()) && !empty($recipeAdd->getNumberOfPeople()) && !empty($recipeAdd->getTime())) ? 'visible' : 'visible'; ?>" id="hiddenContentAddRecipe">
        <div class="col-7">
            <h3 class="mb-2 mt-2">Preparation</h3>
            <div class="form-group">
                <div id="paragraphesAddRecipe" class="d-flex flex-column"></div>
                <button id="addParagraphNewRecipe" class="btn" onclick="addParagraph()">
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
                    <input list="ingredientsAdd" type="text" class="form-control p-0" id="inputIngredientNameAddRecipe" name="ingredient">
                    <datalist id="ingredientsAddListAddRecipe">
                        <?php
                        foreach ($listAllIngredients as $ingredients) {
                            echo '<option value="' . ($ingredients->getProductName()) . '">';
                        }
                        ?>
                    </datalist>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <div class="col-4 p-0"><input type="text" class="form-control" placeholder="Quantity" name="quantity" id="inputIngredientQuantityAddRecipe"></div>
                    <div class="col-2 p-0"><input type="text" class="form-control" placeholder="Unit of Measure" name="unitMeasure" id="inputIngredientUnitAddRecipe"></div>
                    <input type="text" class="form-control" name="idRecipeIngredient" id="idRecipeIngredient" value="<?= $recipeAdd->getIdRecipe() ?>" hidden>
                    <button id="okIngredientAddRecipe" type="submit" class="btn mr-5">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
    const ROOT = '<?= BASE_URL ?>';

    var buttonOkIngredient = document.querySelector("#okIngredientAddRecipe");
    buttonOkIngredient.addEventListener('click', (function(e) {
        event.preventDefault();
        const idRecipe = document.querySelector('#idRecipeIngredient').value;
        const nameIngredient = document.querySelector('#inputIngredientNameAddRecipe').value;
        const quantityIngredient = document.querySelector('#inputIngredientQuantityAddRecipe').value;
        const unitIngredient = document.querySelector('#inputIngredientUnitAddRecipe').value;
        var divList = document.querySelector("#addIngredientListAddRecipe");
        if (idRecipe != null) {
            addIngredient(idRecipe, nameIngredient, quantityIngredient, unitIngredient).then((response) => {
                if (response) {
                    if (response.success) {
                        console.log(response)
                        console.log(divList);
                        console.log("test");
                        divList.innerHTML+=response.recipeIngredient;
                        alert('Ingredient added');
                    } else {
                        console.log(response.errorMessages)
                    }
                }
            });
        }
    }))

    /**
     * Ajax Request to add ingredients to a recipe
     * @param int idRecipe, string nameIngredient, int quantityIngredient, string unitIngredient
     * @returns mixed
     */
    async function addIngredient(idRecipe, nameIngredient, quantityIngredient, unitIngredient) {
        var myHeaders = new Headers();

        let formData = new FormData();
        formData.append('id_recipe', idRecipe);
        formData.append('name_ingredient', nameIngredient);
        formData.append('quantity_ingredient', quantityIngredient);
        formData.append('unit_ingredient', unitIngredient);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/addingredient', myInit);
        try {
            if (response.ok) {
                return await response.json();
            } else {
                return false;
            }
        } catch (e) {
            console.error(e.message);
        }
    }


    var index = 0;

    function addParagraph() {

        createEntitiesParagraph();

        addButtons();


        // We add then evenListener on each svg type (still in the addParagraph listener because this is where there are created)
        var bins = document.querySelectorAll(".deleteSvg");
        if (bins != null) {
            bins.forEach(bin =>
                bin.addEventListener('click', () => event.target.parentNode.parentNode.remove())
            )
        }

        var downs = document.querySelectorAll(".downSvg");
        if (downs != null) {
            downs.forEach(down =>
                down.addEventListener('click', () => console.log("okDown"))
            )
        }

        var ups = document.querySelectorAll(".upSvg");
        if (ups != null) {
            ups.forEach(up =>
                up.addEventListener('click', () => console.log("okUp"))
            )
        }

    }

    /**
     * This function create all the elements needed for the paragraph (div, textareas)
     */
    function createEntitiesParagraph() {
        index++;
        // get the paragraphes area
        var paragraphArea = document.querySelector("#paragraphesAddRecipe");

        // create a paragraphLine element
        var paragraphLine = document.createElement('div');
        paragraphLine.className = "paragraphAddRecipeLine d-flex flex-row flex-wrap justify-content-between"
        paragraphLine.setAttribute('data-id', index);
        paragraphLine.setAttribute('order', index)

        // create the textarea element
        var textLine = document.createElement('textarea');
        textLine.className = "form-control mb-2 paragraphAddRecipe";
        textLine.setAttribute('data-id', index);
        textLine.setAttribute('data-order', index)
        textLine.setAttribute('rows', 5)
        textLine.style.resize = "none";

        // create the div where the icons will be
        var divIcon = document.createElement('div');
        divIcon.className = "paragraphIcons";

        paragraphLine.appendChild(divIcon);
        paragraphLine.appendChild(textLine);
        paragraphArea.appendChild(paragraphLine);
    }


    /**
     * This function add the buttons up, down and delete according to the order of the paragraph
     */
    function addButtons() {
        var paragrapheLines = document.querySelectorAll(".paragraphAddRecipeLine");
        var divIcons = document.querySelectorAll(".paragraphIcons");
        for (i = 0; i < paragrapheLines.length; i++) {
            // create the img icon up
            var svgUp = document.createElement('img');
            svgUp.className = "upSvg";
            svgUp.src = ROOT_ICONS + 'up-svg.png';
            svgUp.alt = "arrow up icon";

            // create the img icon down
            var svgDown = document.createElement('img');
            svgDown.className = "downSvg";
            svgDown.src = ROOT_ICONS + 'down-svg.png';
            svgDown.alt = "arrow down icon";

            // create the img icon delete
            var svgDelete = document.createElement('img');
            svgDelete.className = "deleteSvg";
            svgDelete.src = ROOT_ICONS + 'delete-svg.png';
            svgDelete.alt = "delete icon";

            if (i == 0) { // if this is the first paragraph
                if (paragrapheLines.length > 1) { // if there is more than 1 paragraph
                    divIcons[i].innerHTML = "";
                    divIcons[i].appendChild(svgDown);
                    divIcons[i].appendChild(svgDelete);
                } else { // if there is only 1 paragraph
                    divIcons[i].innerHTML = "";
                    divIcons[i].appendChild(svgDelete);
                }
            } else if (i == paragrapheLines.length - 1 && paragrapheLines.length > 1) { // if this is the last paragraph and there is more than one
                divIcons[i].innerHTML = "";
                divIcons[i].appendChild(svgUp);
                divIcons[i].appendChild(svgDelete);
            } else {
                divIcons[i].innerHTML = "";
                divIcons[i].appendChild(svgUp);
                divIcons[i].appendChild(svgDown);
                divIcons[i].appendChild(svgDelete);
            }
        }
    }
</script>