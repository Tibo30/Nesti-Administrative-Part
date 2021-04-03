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
            <form method="post" id="editRecipeForm">
                <div class="form-group">
                    <label for="inputEditRecipeName">Recipe name</label>
                    <input type="text" class="form-control p-0" id="inputEditRecipeName" name="recipeName" value="<?= $recipe->getRecipeName() ?>">
                    <small id="recipeChiefName" class="form-text text-muted">Recipe Chief : <?= $recipe->getChief()->getLastname() . " " . $recipe->getChief()->getFirstname() ?></small>
                </div>
                <span class="text-danger" id="errorEditRecipeName"></span>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputEditDifficulty">Difficulty (grade on 5)</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputEditDifficulty" name="difficulty" value="<?= $recipe->getDifficulty() ?>"></div>
                </div>
                <span class="text-danger" id="errorEditDifficulty"></span>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputEditNumberOfPeople">Number of people</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputEditNumberOfPeople" name="numberOfPeople" value="<?= $recipe->getNumberOfPeople() ?>"></div>
                </div>
                <span class="text-danger" id="errorEditNumberPeople"></span>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="inputEditPreparationTime">Preparation time in minutes</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="inputEditPreparationTime" name="preparationTime" value="<?= $recipe->getTime() ?>"></div>
                </div>
                <span class="text-danger" id="errorEditTime"></span>
                <div class="d-flex flex-row">
                    <button id="submitEditRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelEditRecipe" type="reset" class="btn">Cancel</button>
                </div>
            </form>
            <input type="text" class="form-control" name="idRecipe" id="idRecipe" value="<?= $recipe->getIdRecipe() ?>" hidden>
        </div>

        <div id="editPicture">
            <div id="recipePictureEdit" class="bg-light border mb-2" style='background-image:url("<?= $recipe->getIdPicture() != null ? BASE_URL . PATH_PICTURES . $recipe->getPicture()->getName() . "." . $recipe->getPicture()->getExtension() : "" ?>")'></div>
            <div class=" d-flex flex-row justify-content-between">
                <p class="recipePictureEditName"><?= $recipe->getIdPicture() != null ? ($recipe->getPicture()->getName() . "." . $recipe->getPicture()->getExtension()) : "" ?></p>
                <a id="deletePictureRecipeButton" href="">
                    <div class="recipePictureBin"><img src="<?php echo BASE_URL . PATH_ICONS ?>delete-svg.svg" alt="svg bin"></div>
                </a>
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
                <div id="addIngredientListEditRecipe" class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                    <?php foreach ($recipeIngredients as $recipeIngredient) {
                        echo ' <div class="d-flex flex-row justify-content-between"> <div class="mb-3"> ' . $recipeIngredient->getQuantity() . " " . $recipeIngredient->getUnitMeasure()->getName() . " de " . $recipeIngredient->getIngredient()->getProductName() . ' </div><div onclick="listenerDeleteIngredient(event)" class="btn-delete-ingredient" data-idingredient="' . $recipeIngredient->getIDIngredient() . '" data-idrecipe="' . $recipeIngredient->getIdRecipe() . '" data-order="' . $recipeIngredient->getOrder() . '">delete</div></div>';
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
                    <div class="col-4 p-0"><input type="text" class="form-control" placeholder="Quantity" name="quantity" id="inputIngredientQuantityEditRecipe"></div>
                    <div class="col-2 p-0"><input type="text" class="form-control" placeholder="Unit of Measure" name="unitMeasure" id="inputIngredientUnitEditRecipe"></div>
                    <button id="okIngredientEditRecipe" type="submit" class="btn mr-5">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
    const ROOT = '<?= BASE_URL ?>';

    // -------------------------------- Edit recipe --------------------------//  

    var formEditRecipe = document.querySelector("#editRecipeForm"); // get the form used to edit the recipe
    // Event listener on the form
    formEditRecipe.addEventListener('submit', (function(e) {
        event.preventDefault(); // stop the default action of the form
        const idRecipe = document.querySelector('#idRecipe').value;
        editRecipe(this, idRecipe).then((response) => {
            if (response) {
                if (response.success) {
                    console.log(response);
                    document.querySelector("#inputEditRecipeName").value = response.nameRecipe;
                    document.querySelector("#inputEditDifficulty").value = response.difficultyRecipe;
                    document.querySelector("#inputEditNumberOfPeople").value = response.numberPeopleRecipe;
                    document.querySelector("#inputEditPreparationTime").value = response.timeRecipe;

                    document.querySelector("#errorEditRecipeName").innerHTML = "";
                    document.querySelector("#errorEditDifficulty").innerHTML = "";
                    document.querySelector("#errorEditNumberPeople").innerHTML = "";
                    document.querySelector("#errorEditTime").innerHTML = "";

                    document.querySelector("#idRecipe").value = response.idRecipe;

                    alert("recipe edited");
                } else {
                    document.querySelector("#errorEditRecipeName").innerHTML = response.errorMessages['recipeName'];
                    document.querySelector("#errorEditDifficulty").innerHTML = response.errorMessages['difficulty'];
                    document.querySelector("#errorEditNumberPeople").innerHTML = response.errorMessages['numberOfPeople'];
                    document.querySelector("#errorEditTime").innerHTML = response.errorMessages['preparationTime'];
                }
            }
        });
    }))

    /**
     * Ajax Request to edit the recipe
     * @param {form} obj, int idRecipe
     * @returns mixed
     */
    async function editRecipe(obj, idRecipe) {
        var myHeaders = new Headers();

        let formData = new FormData(obj);
        formData.append('id_recipe', idRecipe);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/editrecipe', myInit);
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

    // -------------------------------- Edit recipe picture --------------------------//   

    const form = document.querySelector("#formEditRecipeImage"); // get the form used to add the picture
    // Event listener on the form
    form.addEventListener('submit', (function(e) {
        event.preventDefault(); // stop the default action of the form
        const img = document.querySelector("#InputFileEditRecipe");
        const idRecipe = document.querySelector('#idRecipe').value;
        if (img.value != "") {
            editPicture(this, idRecipe).then((response) => {
                if (response) {
                    if (response.success) {
                        console.log(response);
                        const namePicture = document.querySelector(".recipePictureEditName"); // get the paragraph where the name of the picture is written
                        const divPicture = document.querySelector("#recipePictureEdit"); // get the div where the picture is displayed
                        namePicture.innerHTML = response["picture"]; // change the name of the picture
                        divPicture.style.backgroundImage = "url(" + response["urlPicture"] + ")"; // change the background image of the div with the new picture
                        if (response.MessageDb != null) { // if there is a message from the Db (if the name of the picture is already taken)
                            alert(response.MessageDb);
                        } else {
                            alert('Picture changed');
                        }
                    } else {
                        if (response.errorMove != null) { // if the picture has not been moved
                            alert(response.errorMove);
                        }
                    }
                }
            });
        }

    }))

    /**
     * Ajax Request to add the recipe picture
     * @param {form} obj ,int idRecipe
     * @returns mixed
     */
    async function editPicture(obj, idRecipe) {
        var myHeaders = new Headers();

        let formData = new FormData(obj);
        formData.append('id_recipe', idRecipe);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/editpicture', myInit);
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

    // -------------------------------- Delete article picture --------------------------//  

    const deleteButton = document.querySelector("#deletePictureRecipeButton");
    deleteButton.addEventListener('click', (function(e) {
        event.preventDefault();
        const idRecipe = document.querySelector('#idRecipe').value;
        console.log(idRecipe);
        if (idRecipe != null) {
            deletePicture(idRecipe).then((response) => {
                if (response) {
                    if (response.success) {
                        const namePicture = document.querySelector(".recipePictureEditName"); // get the paragraph where the name of the picture is written
                        const divPicture = document.querySelector("#recipePictureEdit"); // get the div where the picture is displayed
                        namePicture.innerHTML = ""; // change the name of the picture to empty
                        divPicture.style.backgroundImage = null; // change the background image of the div to null
                        alert('Picture deleted');
                    }
                }
            });
        }
    }))

    /**
     * Ajax Request to delete the recipe picture
     * @param int idRecipe
     * @returns mixed
     */
    async function deletePicture(idRecipe) {
        var myHeaders = new Headers();

        let formData = new FormData();
        formData.append('id_recipe', idRecipe);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/deletepicture', myInit);
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

    // -------------------------------- Add recipe ingredient --------------------------//   

    var buttonOkIngredient = document.querySelector("#okIngredientEditRecipe");
    buttonOkIngredient.addEventListener('click', (function(e) {
        event.preventDefault();
        const idRecipe = document.querySelector('#idRecipe').value;
        const nameIngredient = document.querySelector('#inputIngredientNameEditRecipe').value;
        const quantityIngredient = document.querySelector('#inputIngredientQuantityEditRecipe').value;
        const unitIngredient = document.querySelector('#inputIngredientUnitEditRecipe').value;
        var divList = document.querySelector("#addIngredientListEditRecipe");
        if (idRecipe != null) {
            addIngredient(idRecipe, nameIngredient, quantityIngredient, unitIngredient).then((response) => {
                if (response) {
                    if (response.success) {
                        divList.innerHTML += response.recipeIngredient;
                        //add event listener to the delete buttons
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
        let response = await fetch(ROOT + 'recipe/editaddingredient', myInit);
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

    // -------------------------------- Delete recipe ingredient --------------------------//   


    function listenerDeleteIngredient(event) {
        event.preventDefault();
        var buttonDelete = event.target;
        const idRecipe = buttonDelete.getAttribute("data-idrecipe");
        const idIngredient = buttonDelete.getAttribute("data-idingredient");
        const order = buttonDelete.getAttribute("data-order");
        var divList = document.querySelector("#addIngredientListEditRecipe");

        if (idRecipe != null && idIngredient != null) {
            deleteIngredient(idRecipe, idIngredient, order).then((response) => {
                if (response) {
                    if (response.success) {
                        divList.innerHTML = ""; //empty the list
                        response['recipeIngredient'].forEach(element => {
                            const div = document.createElement("div");
                            div.innerHTML = element.all;
                            divList.appendChild(div); // add the recipeIngredients to the divList
                        })
                        alert('Ingredient deleted');
                    } else {
                        console.log(response.errorMessages)
                    }
                }
            });
        }
    }


    /**
     * Ajax Request to delete ingredients to a recipe
     * @param int idRecipe, int idIngredient, int order
     * @returns mixed
     */
    async function deleteIngredient(idRecipe, idIngredient, order) {
        var myHeaders = new Headers();

        let formData = new FormData();

        formData.append('id_recipe', idRecipe);
        formData.append('id_ingredient', idIngredient);
        formData.append('order', order);
        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/editdeleteingredient', myInit);
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

    // -------------------------------- Add paragraph --------------------------//  


    addListenerButtons()

    function addParagraph() {

        createEntitiesParagraph();

        addButtons();
    }

    /**
     * This function create all the elements needed for the paragraph (div, textareas)
     */
    function createEntitiesParagraph() {
        paragraphs = document.querySelectorAll(".paragraphEditRecipeLine")
        order = paragraphs[paragraphs.length - 1].getAttribute('order');
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
                    idParagraph = event.target.parentNode.parentNode.getAttribute("data-id");
                    const idRecipe = document.querySelector('#idRecipe').value;
                    if (idParagraph != null) {
                        deleteParagrapheFromDB(idParagraph, idRecipe).then((response) => {
                            if (response) {
                                if (response.success) {
                                    console.log("ok")
                                    alert("Paragraph deleted from Database. Please don't forget to save");
                                } else {
                                    console.log(response.errorMessages)
                                }
                            }
                        });
                    }
                    event.target.parentNode.parentNode.remove();
                    var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine"); // get the list of the remain paragraphs

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
                    console.log(currentParagraph);
                    var nextParagraph = event.target.parentNode.parentNode.nextElementSibling;
                    console.log(nextParagraph);

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

                    var previousParagraph = event.target.parentNode.parentNode.previousElementSibling;
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


    // -------------------------------- Delete paragraphes ------------------------- //

    /**
     * Ajax Request to delete paragraphes
     * @param int idParagraph, int idRecipe
     * @returns mixed
     */
    async function deleteParagrapheFromDB(idParagraph, idRecipe) {
        var myHeaders = new Headers();

        let formData = new FormData();
        formData.append('id_paragraph', idParagraph);
        formData.append('id_recipe', idRecipe);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/deleteparagraph', myInit);
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

    // -------------------------------- Save paragraphes -------------------------- //  

    okParagraphEditRecipe.addEventListener('click', (function(e) {
        event.preventDefault();
        const idRecipe = document.querySelector('#idRecipe').value;
        var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine");
        if (idRecipe != null) {
            var error = "";
            paragraphLines.forEach(element => saveParagraph(idRecipe, element).then((response) => {
                if (response) {
                    if (response.success) {
                        element.setAttribute("data-id", response.id_paragraph);
                    } else {
                        console.log(response.errorMessages)
                        error = response.errorMessages;
                    }
                }
            }))
            if (error == "") {
                alert('Paragraphes saved');
            }

        }
    }))

    /**
     * Ajax Request to save paragraphes
     * @param {div} element, int idRecipe
     * @returns mixed
     */
    async function saveParagraph(idRecipe, element) {
        var myHeaders = new Headers();
        order = element.getAttribute("order");
        idParagraph = element.getAttribute("data-id");
        content = element.children[1].value;

        let formData = new FormData();
        formData.append('id_recipe', idRecipe);
        formData.append('id_paragraph', idParagraph);
        formData.append('order_paragraph', order);
        formData.append('content', content);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'recipe/saveparagraph', myInit);
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
</script>