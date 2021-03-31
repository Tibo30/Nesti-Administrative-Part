<?php
if (!isset($recipe) || empty($recipe)) {
    $recipe = new Recipe();
}
if (!isset($paragraphs)) {
    $paragraphs = [];
    if (!empty($paragraphs)) {
        foreach ($paragraphs as $paragraph) {
            $paragraph = new Paragraph();
        }
    }
}
if (!isset($listAllIngredients)) {
    $listAllIngredients = [];
    if (!empty($recipes)) {
        foreach ($recipes as $ingredients) {
            $ingredients = new Ingredients();
        }
    }
}
if (!isset($ingredients)) {
    $ingredients = [];
    if (!empty($ingredients)) {
        foreach ($ingredients as $ingredient) {
            $ingredient = new Ingredients();
        }
    }
}
?>

<div class="container bg-white align-items-left" id="recipeEditPage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>recipe"><u>Recipes</u>
        </a>
        <p> &nbsp > Edit</p>
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
                <span class="text-danger" id="errorEditRecipeName"></span>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputDifficulty">Difficulty (grade on 5)</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputDifficulty" value="<?= $recipe->getDifficulty() ?>"></div>
                </div>
                <span class="text-danger" id="errorEditDifficulty"></span>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputNumberOfPeople">Number of people</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputNumberOfPeople" value="<?= $recipe->getNumberOfPeople() ?>"></div>
                </div>
                <span class="text-danger" id="errorEditNumberPeople"></span>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputPreparationTime">Preparation time in minutes</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputPreparationTime" value="<?= $recipe->getTime() ?>"></div>
                </div>
                <span class="text-danger" id="errorEditTime"></span>
                <div class="d-flex flex-row">
                    <button id="submitEditRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelEditRecipe" type="reset" class="btn">Cancel</button>
                </div>

            </form>
        </div>

        <div id="editPicture">
            <div id="recipePictureEdit" class="bg-light border mb-2" style='background-image:url("<?= $recipe->getIdPicture() != null ? BASE_URL . PATH_PICTURES . $recipe->getPicture()->getName() . "." . $recipe->getPicture()->getExtension() : "" ?>")'></div>
            <div class=" d-flex flex-row justify-content-between">
                <p class="recipePictureEditName"><?= $recipe->getIdPicture() != null ? ($recipe->getPicture()->getName() . "." . $recipe->getPicture()->getExtension()) : "" ?></p>
            </div>
            <label class="form-label" for="customFile">Download a new picture</label>

            <div class="custom-file">
                <form id="formEditRecipeImage" action="" enctype="multipart/form-data" method="post">
                    <div class="d-flex flex-column">
                        <input type="file" class="custom-file-input" id="InputFileEditRecipe" name="image">
                        <!-- le name dans le input se retrouve dans le $_FILES['image'] -->
                        <button type="submit" class="align-self-end mt-1 btn" id="btn-edit-recipe-picture">OK</button>
                    </div>
                    <label class="custom-file-label" for="InputFileEditRecipe" data-browse="Browse"></label>
                </form>
            </div>
        </div>

    </div>

    <div class="container px-0 mx-0 mt-5 bg-light d-flex flex-row justify-content-between">
        <div class="col-7">
            <h3 class="mb-2 mt-2">Preparation</h3>
            <div class="form-group">
                <div id="paragraphsEditRecipe" class="d-flex flex-column">

                    <?php
                    $index = 0;
                    $paragraphs = $recipe->getParagraphs();
                    foreach ($paragraphs as $paragraph) {
                        if ($index == 0) { // if this is the first paragraph
                            if (count($paragraphs) > 1) { // if there is more than 1 paragraph
                                echo '<div class="paragraphEditRecipeLine d-flex flex-row flex-wrap justify-content-between" order="' . $paragraph->getOrder() . '" data-id="' . $paragraph->getIdParagraph() . '">
                        <div class="paragraphIcons"><img class="downSvg" src="' . BASE_URL . PATH_ICONS . 'down-svg.png" alt="arrow down icon" ><img class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                        <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                        </div>';
                            } else { // if there is only 1 paragraph
                                echo '<div class="paragraphEditRecipeLine d-flex flex-row flex-wrap justify-content-between" order="' . $paragraph->getOrder() . '" data-id="' . $paragraph->getIdParagraph() . '">
                        <div class="paragraphIcons"><img class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                        <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                        </div>';
                            }
                        } else if ($index == count($paragraphs) - 1 && count($paragraphs) > 1) { // if this is the last paragraph and there is more than one
                            echo '<div class="paragraphEditRecipeLine d-flex flex-row flex-wrap justify-content-between" order="' . $paragraph->getOrder() . '" data-id="' . $paragraph->getIdParagraph() . '">
                        <div class="paragraphIcons"><img class="upSvg" src="' . BASE_URL . PATH_ICONS . 'up-svg.png" alt="arrow up icon" ><img class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                        <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                        </div>';
                        } else {
                            echo '<div class="paragraphEditRecipeLine d-flex flex-row flex-wrap justify-content-between" order="' . $paragraph->getOrder() . '" data-id="' . $paragraph->getIdParagraph() . '">
                            <div class="paragraphIcons"><img class="upSvg" src="' . BASE_URL . PATH_ICONS . 'up-svg.png" alt="arrow up icon" ><img class="downSvg" src="' . BASE_URL . PATH_ICONS . 'down-svg.png" alt="arrow down icon" ><img class="deleteSvg" src="' . BASE_URL . PATH_ICONS . 'delete-svg.png" alt="delete icon" ></div>
                            <textarea class="form-control mb-2 paragraphEditRecipe" rows="5" max-length="255" style="resize: none;">' . $paragraph->getContent() . '</textarea>
                            </div>';
                        }
                        $index++;
                    }
                    ?>
                    
                </div>
                <div class="d-flex flex-column align-items-center">
                        <button id="addParagraphEditRecipe" class="btn" onclick="addParagraph()">
                            <div class="fas fa-plus"></div>
                        </button>
                        <button id="okParagraphEditRecipe" type="submit" class="btn">SAVE</button>
                    </div>
            </div>
        </div>
        <div class="col-4">
            <h3 class="mb-2 mt-2">Ingredient List</h3>
            <div class="form-group">
                <div class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                    <?php foreach ($recipeIngredients as $recipeIngredient) {
                        echo ' <div class="d-flex flex-row justify-content-between"> <p> ' . $recipeIngredient->getQuantity() . " " . $recipeIngredient->getUnitMeasure()->getName() . " de " . $recipeIngredient->getIngredient()->getProductName() . ' </p><div><a class="btn-remove-ingredients" onclick="deleteIngredient()">Delete</a></div></div>';
                    }
                    ?>
                </div>
                <div class="col-12 p-0 mb-3">
                    <label for="inputIngredientNameEditRecipe">Add an ingredient</label>
                    <input list="ingredientsEdit" type="text" class="form-control p-0" id="inputIngredientNameEditRecipe">
                    <datalist id="ingredientsEdit">
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
                    <button id="okIngredientEditRecipe" type="submit" class="btn mr-5">ok</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
    const ROOT = '<?= BASE_URL ?>';

    addListenerButtons()

    function addParagraph() {

        createEntitiesParagraph();

        addButtons();
    }

    /**
     * This function create all the elements needed for the paragraph (div, textareas)
     */
    function createEntitiesParagraph() {
        paragraphs= document.querySelectorAll(".paragraphEditRecipeLine")
        order = paragraphs[paragraphs.length-1].getAttribute('order');
        console.log(order);
        order++;
        // get the paragraphes area
        var paragraphArea = document.querySelector("#paragraphsEditRecipe");

        // create a paragraphLine element
        var paragraphLine = document.createElement('div');
        paragraphLine.className = "paragraphEditRecipeLine d-flex flex-row flex-wrap justify-content-between"
        paragraphLine.setAttribute('order', order)

        // create the textarea element
        var textLine = document.createElement('textarea');
        textLine.className = "form-control mb-2 paragraphEditRecipe";
        textLine.setAttribute('rows', 5)
        textLine.setAttribute('maxlength', 255)
        textLine.style.resize = "none";

        // create the div where the icons will be
        var divIcon = document.createElement('div');
        divIcon.className = "paragraphIcons";

        paragraphLine.appendChild(divIcon);
        paragraphLine.appendChild(textLine);
        paragraphArea.appendChild(paragraphLine);
    }

    function addListenerButtons() {
        // We add then evenListener on each svg type (still in the addParagraph listener because this is where there are created)
        var bins = document.querySelectorAll(".deleteSvg");
        if (bins != null) {
            bins.forEach(bin =>
                bin.addEventListener('click', function() {
                    idParagraph = event.target.parentNode.parentNode.getAttribute("id");
                    if (idParagraph != null) {
                        deleteParagrapheFromDB(idParagraph).then((response) => {
                            if (response) {
                                if (response.success) {
                                    console.log("ok")
                                    alert('Paragraph deleted from Database');
                                } else {
                                    console.log("probleme")
                                    console.log(response.errorMessages)
                                }
                            }
                        });
                    }
                    event.target.parentNode.parentNode.remove();
                    var paragraphLines = document.querySelectorAll(".paragraphAddRecipeLine"); // get the list of the remain paragraphs

                    paragraphLines.forEach(function(element, index) { // we change the attribute order
                        element.setAttribute('order', index + 1)
                    });
                    addButtons(); // we do again the addButtons function
                })
            )
        }

        var downs = document.querySelectorAll(".downSvg");
        if (downs != null) {
            downs.forEach(down =>
                down.addEventListener('click', function() {
                    var currentParagraph = event.target.parentNode.parentNode;
                    console.log(currentParagraph);

                    var currentOrder = Number(currentParagraph.getAttribute('order')) - 1; // get the attribute to know its position in the list of paragraphs(order-1)
                    currentParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) + 1);

                    var nextParagraph = event.target.parentNode.parentNode.nextSibling;
                    
                    nextParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) - 1);
                    
                    var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine"); // get the list of paragraphs

                    paragraphLines[currentOrder].parentNode.insertBefore(paragraphLines[currentOrder], paragraphLines[currentOrder + 1].nextSibling); // = insert after

                    addButtons(); // we do again the addButtons function
                    alert("Please don't forget to save");
                })
            )
        }

        var ups = document.querySelectorAll(".upSvg");
        if (ups != null) {
            ups.forEach(up =>
                up.addEventListener('click', function() {

                    var currentParagraph = event.target.parentNode.parentNode;

                    var currentOrder = Number(currentParagraph.getAttribute('order')) - 1; // get the attribute to know its position in the list of paragraphs(order-1)
                    currentParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) - 1);

                    var previousParagraph = event.target.parentNode.parentNode.previousSibling;
                    previousParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) + 1);

                    var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine"); // get the list of paragraphs

                    paragraphLines[currentOrder].parentNode.insertBefore(paragraphLines[currentOrder], paragraphLines[currentOrder - 1]);

                    addButtons(); // we do again the addButtons function
                    alert("Please don't forget to save");
                })
            )
        }
    }

    /**
     * This function add the buttons up, down and delete according to the order of the paragraph
     */
    function addButtons() {
        var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine");
        var divIcons = document.querySelectorAll(".paragraphIcons");
        for (i = 0; i < paragraphLines.length; i++) {
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
                if (paragraphLines.length > 1) { // if there is more than 1 paragraph
                    divIcons[i].innerHTML = "";
                    divIcons[i].appendChild(svgDown);
                    divIcons[i].appendChild(svgDelete);
                } else { // if there is only 1 paragraph
                    divIcons[i].innerHTML = "";
                    divIcons[i].appendChild(svgDelete);
                }
            } else if (i == paragraphLines.length - 1 && paragraphLines.length > 1) { // if this is the last paragraph and there is more than one
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
        addListenerButtons();
    }

</script>