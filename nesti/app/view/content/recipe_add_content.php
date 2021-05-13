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

<?php if (array_search("chief", $_SESSION["roles"]) !== false) {

?>
    <div class="container bg-white align-items-left position-relative" id="recipeAddPage">
        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>recipe"><u>Recipes</u>
            </a>
            <p> &nbsp > Create</p>
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
                <label class="form-label" for="customFile">Download a new picture</label>

                <div class="custom-file">
                    <form id="formAddRecipeImage" action="" enctype="multipart/form-data" method="post">
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
                            <div class="fas fa-plus"></div>
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

        // hide the notification after a click
        var notifs = document.querySelectorAll(".notifications");
        notifs.forEach(element =>
            element.addEventListener('click', (function(e) {
                element.hidden = true;
            }))
        )

        function updatePictureName() {
            var input = document.querySelector("#InputFileAddRecipe");
            var output = document.querySelector('.pictureNameInput');
            output.innerHTML = input.files.item(0).name;
        }

        // create the modal needed on a click on the delete ingredient button
        function createModalDeleteIngredient(order, idRecipe, idIngredient) {
            var divModal = document.createElement("div"); //create a div
            divModal.style.position = "absolute";
            var line = event.target.parentNode; // get the ingredient line

            var newModal = '<div class="modal fade" id="modalRecipeDeleteIngredient' + Number(order) + '" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" ' +
                'aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">' +
                '<div class="modal-header"> <h5 class = "modal-title" id = "exampleModalLongTitle" > Do you really want to delete this ingredient? </h5> <button type = "button" ' +
                'class = "close" id = "closeModalAddRecipeDeleteIngredient' + idIngredient + '" data-dismiss = "modal" aria-label = "Close"> ' +
                '<span aria-hidden="true"> &times; </span> </button> </div>  <div class = "modal-footer" >' +
                '<button id = "confirm-add-recipe-delete-ingredient" type = "button" class = "btn"> Confirm </button> ' +
                '<button type = "button" class = "btn btn-danger" data-dismiss = "modal" > Cancel </button> </div> </div> </div> </div>';

            divModal.innerHTML = newModal;
            line.appendChild(divModal); // add the div to the ingredient line

            var opener = document.getElementById("openModalIngredient" + Number(order)); // get the hidden div that can open the modal
            opener.click(); // simulate a click on this button

            var confirmDeleteIngredient = document.querySelector("#confirm-add-recipe-delete-ingredient");
            if (confirmDeleteIngredient != null) {
                confirmDeleteIngredient.addEventListener('click', function() {
                    listenerDeleteIngredient(order, idRecipe, idIngredient)
                    document.querySelector("#closeModalAddRecipeDeleteIngredient" + idIngredient).click(); // simulate a click on the close modal button
                })
            }
        }

        // create the modal needed on a click on the bin svg
        function createModal(order, id) {

            var divModal = document.createElement("div"); //create a div
            divModal.style.position = "absolute";
            var para = event.target.parentNode.parentNode; // get the paragraphline

            var newModal = '<div class="modal fade" id="modalEditRecipeDeleteParagraph' + Number(order) + '" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" ' +
                'aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content">' +
                '<div class="modal-header"> <h5 class = "modal-title" id = "exampleModalLongTitle" > Do you really want to delete this paragraph ? </h5> <button type = "button" ' +
                'class = "close" id = "closeModalEditRecipeDeleteParagraph' + id + '" data-dismiss = "modal" aria-label = "Close"> ' +
                '<span aria-hidden="true"> &times; </span> </button> </div>  <div class = "modal-footer" >' +
                '<button id = "confirm-edit-recipe-delete-paragraph" type = "button" class = "btn" data-id = "' + id + '"> Confirm </button> ' +
                '<button type = "button" class = "btn btn-danger" data-dismiss = "modal" > Cancel </button> </div> </div> </div> </div>';

            divModal.innerHTML = newModal;
            para.appendChild(divModal); // add the div to the paragraphline

            var opener = document.getElementById("openModal" + Number(order)); // get the hidden div that can open the modal
            opener.click(); // simulate a click on this button

            // add event listener on the modal confirm button
            var confirmBin = document.querySelector("#confirm-edit-recipe-delete-paragraph");
            if (confirmBin != null) {
                confirmBin.addEventListener('click', function() {
                    var idParagraph = id;
                    const idRecipe = document.querySelector('#idRecipe').value;
                    if (idParagraph != null) {
                        deleteParagrapheFromDB(idParagraph, idRecipe).then((response) => {
                            if (response) {
                                if (response.success) {
                                    document.querySelector("#recipeEditParagraphDeletedSuccess").hidden = false;
                                } else {
                                    console.log(response.errorMessages)
                                }
                            }
                        });
                    }
                    document.querySelector("#closeModalEditRecipeDeleteParagraph" + idParagraph).click(); // simulate a click on the close modal button
                    para.remove(); // get the lineparagraph entity and remove it
                    var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine"); // get the list of the remain paragraphs

                    paragraphLines.forEach(function(element, index) { // we change the attribute order
                        element.setAttribute('order', index + 1)
                    });
                    addButtons(); // we do again the addButtons function
                })
            }
        }

        // -------------------------------- Add recipe --------------------------//  

        var formAddRecipe = document.querySelector("#addRecipeForm"); // get the form used to add the recipe
        // Event listener on the form
        formAddRecipe.addEventListener('submit', (function(e) {
            event.preventDefault(); // stop the default action of the form
            addRecipe(this).then((response) => {
                if (response) {
                    if (response.success) {
                        //
                        document.querySelector("#inputAddRecipeName").value = response.nameRecipe;
                        document.querySelector("#inputAddDifficulty").value = response.difficultyRecipe;
                        document.querySelector("#inputAddNumberOfPeople").value = response.numberPeopleRecipe;
                        document.querySelector("#inputAddPreparationTime").value = response.timeRecipe;

                        document.querySelector("#errorRecipeName").innerHTML = "";
                        document.querySelector("#errorDifficulty").innerHTML = "";
                        document.querySelector("#errorNumberPeople").innerHTML = "";
                        document.querySelector("#errorTime").innerHTML = "";

                        document.querySelector("#idRecipe").value = response.idRecipe;

                        document.querySelector("#addPicture").classList.remove("invisible");
                        document.querySelector("#addPicture").classList.add("visible");
                        document.querySelector("#hiddenContentAddRecipe").classList.remove("invisible");
                        document.querySelector("#hiddenContentAddRecipe").classList.add("visible");

                        document.querySelector("#recipeCreatedSuccess").hidden = false;
                    } else {
                        document.querySelector("#errorRecipeName").innerHTML = response.errorMessages['recipeName'];
                        document.querySelector("#errorDifficulty").innerHTML = response.errorMessages['difficulty'];
                        document.querySelector("#errorNumberPeople").innerHTML = response.errorMessages['numberOfPeople'];
                        document.querySelector("#errorTime").innerHTML = response.errorMessages['preparationTime'];
                    }
                }
            });
        }))

        /**
         * Ajax Request to add a recipe to the database
         * @param {form} obj
         * @returns mixed
         */
        async function addRecipe(obj) {
            var myHeaders = new Headers();

            let formData = new FormData(obj);

            var myInit = {
                method: 'POST',
                headers: myHeaders,
                mode: 'cors',
                cache: 'default',
                body: formData
            };
            let response = await fetch(ROOT + 'recipe/add', myInit);
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

        // -------------------------------- Add recipe picture --------------------------//   

        const form = document.querySelector("#formAddRecipeImage"); // get the form used to add the picture
        // Event listener on the form
        form.addEventListener('submit', (function(e) {
            event.preventDefault(); // stop the default action of the form
            const img = document.querySelector("#InputFileAddRecipe");
            const idRecipe = document.querySelector('#idRecipe').value;
            if (img.value != "") {
                addPicture(this, idRecipe).then((response) => {
                    if (response) {
                        if (response.success) {
                            console.log(response);
                            const namePicture = document.querySelector(".recipePictureAddName"); // get the paragraph where the name of the picture is written
                            const divPicture = document.querySelector("#recipePictureAdd"); // get the div where the picture is displayed
                            namePicture.innerHTML = response["picture"]; // change the name of the picture
                            divPicture.style.backgroundImage = "url(" + response["urlPicture"] + ")"; // change the background image of the div with the new picture
                            if (response.MessageDb != null) { // if there is a message from the Db (if the name of the picture is already taken)
                                var notifInfoPicture = document.querySelector("#recipePictureAddInfo");
                                notifInfoPicture.hidden = false;
                                notifInfoPicture.children[0].innerHTML = response.MessageDb;
                            } else {
                                document.querySelector("#recipePictureAddSuccess").hidden = false;
                            }
                        } else {
                            if (response.errorMove != null) { // if the picture has not been moved
                                var notifErrorPicture = document.querySelector("#recipePictureAddError");
                                notifErrorPicture.hidden = false;
                                notifErrorPicture.children[0].innerHTML = response.errorMove;
                            }
                        }
                    }
                });
            }

        }))

        /**
         * Ajax Request to add the recipe picture
         * @param {form} obj, int idRecipe
         * @returns mixed
         */
        async function addPicture(obj, idRecipe) {
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
            let response = await fetch(ROOT + 'recipe/addpicture', myInit);
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

        var buttonOkIngredient = document.querySelector("#okIngredientAddRecipe");
        buttonOkIngredient.addEventListener('click', (function(e) {
            event.preventDefault();
            const idRecipe = document.querySelector('#idRecipe').value;
            const nameIngredient = document.querySelector('#inputIngredientNameAddRecipe').value;
            const quantityIngredient = document.querySelector('#inputIngredientQuantityAddRecipe').value;
            const unitIngredient = document.querySelector('#inputIngredientUnitAddRecipe').value;
            var divList = document.querySelector("#addIngredientListAddRecipe");
            if (idRecipe != null) {
                addIngredient(idRecipe, nameIngredient, quantityIngredient, unitIngredient).then((response) => {
                    if (response) {
                        if (response.success) {
                            divList.innerHTML += response.recipeIngredient;
                            document.querySelector("#errorRecipeAddQuantity").innerHTML = "";
                            document.querySelector("#errorRecipeAddIngredient").innerHTML = "";
                            document.querySelector("#errorRecipeAddUnit").innerHTML = "";

                            document.querySelector("#inputIngredientNameAddRecipe").value = "";
                            document.querySelector("#inputIngredientQuantityAddRecipe").value = "";
                            document.querySelector("#inputIngredientUnitAddRecipe").value = "";

                            document.querySelector("#recipeIngredientAddSuccess").hidden = false;
                        } else {
                            console.log(response.errorMessages)
                            document.querySelector("#errorRecipeAddQuantity").innerHTML = response.errorMessages['quantity'];
                            document.querySelector("#errorRecipeAddIngredient").innerHTML = response.errorMessages['productName'];
                            document.querySelector("#errorRecipeAddUnit").innerHTML = response.errorMessages['unitName'];
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

        // -------------------------------- Delete recipe ingredient --------------------------//   


        function listenerDeleteIngredient(order, idRecipe, idIngredient) {
            event.preventDefault();
            var divList = document.querySelector("#addIngredientListAddRecipe");

            if (idRecipe != null && idIngredient != null) {
                deleteIngredient(idRecipe, idIngredient, order).then((response) => {
                    if (response) {
                        if (response.success) {
                            divList.innerHTML = ""; //empty the list
                            if (response['recipeIngredient'] != undefined) {
                                response['recipeIngredient'].forEach(element => {
                                    const div = document.createElement("div");
                                    div.innerHTML = element.all;
                                    divList.appendChild(div); // add the recipeIngredients to the divList
                                })
                            }
                            document.querySelector("#recipeIngredientDeletedSuccess").hidden = false;
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
            let response = await fetch(ROOT + 'recipe/deleteingredient', myInit);
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

        var order = 0;

        function addParagraph() {
            document.querySelector("#recipeParagraphMovedSuccess").hidden = false;

            createEntitiesParagraph();

            addButtons();
        }

        /**
         * This function create all the elements needed for the paragraph (div, textareas)
         */
        function createEntitiesParagraph() {
            order++;
            // get the paragraphes area
            var paragraphArea = document.querySelector("#paragraphsAddRecipe");

            // create a paragraphLine element
            var paragraphLine = document.createElement('div');
            paragraphLine.className = "paragraphAddRecipeLine d-flex flex-row flex-wrap justify-content-between"
            paragraphLine.setAttribute('order', order)

            // create the textarea element
            var textLine = document.createElement('textarea');
            textLine.className = "form-control mb-2 paragraphAddRecipe";
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


        /**
         * This function add the buttons up, down and delete according to the order of the paragraph
         */
        function addButtons() {
            var paragraphLines = document.querySelectorAll(".paragraphAddRecipeLine");
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
                svgDelete.setAttribute("onclick", "createModal(" + Number(i + 1) + "," + paragraphLines[i].getAttribute("data-id") + ")");

                // create the open modal div
                var openModal = document.createElement("div");
                openModal.setAttribute("id", "openModal" + Number(i + 1));
                openModal.hidden = true;
                openModal.setAttribute("data-toggle", "modal");
                openModal.setAttribute("data-target", "#modalEditRecipeDeleteParagraph" + Number(i + 1));



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

                // if there is already a modal created
                if (paragraphLines[i].children[3] !== undefined) {
                    paragraphLines[i].children[3].remove();
                }
                // if there is already an openModal div
                if (paragraphLines[i].children[2] !== undefined) {
                    paragraphLines[i].children[2].remove();
                }
                paragraphLines[i].appendChild(openModal);
            }
            addListenerButtons();
        }

        function addListenerButtons() {
            // We add then evenListener down and up svg (still in the addParagraph listener because this is where there are created)

            var downs = document.querySelectorAll(".downSvg");
            if (downs != null) {
                downs.forEach(down =>
                    down.addEventListener('click', function() {
                        var currentParagraph = event.target.parentNode.parentNode;

                        var currentOrder = Number(currentParagraph.getAttribute('order')) - 1; // get the attribute to know its position in the list of paragraphs(order-1)
                        currentParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) + 1);

                        var nextParagraph = event.target.parentNode.parentNode.nextElementSibling;
                        nextParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) - 1);

                        var paragraphLines = document.querySelectorAll(".paragraphAddRecipeLine"); // get the list of paragraphs

                        paragraphLines[currentOrder].parentNode.insertBefore(paragraphLines[currentOrder], paragraphLines[currentOrder + 1].nextSibling); // = insert after

                        addButtons(); // we do again the addButtons function
                        document.querySelector("#recipeParagraphMovedSuccess").hidden = false;
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

                        var paragraphLines = document.querySelectorAll(".paragraphAddRecipeLine"); // get the list of paragraphs

                        paragraphLines[currentOrder].parentNode.insertBefore(paragraphLines[currentOrder], paragraphLines[currentOrder - 1]);

                        addButtons(); // we do again the addButtons function
                        document.querySelector("#recipeParagraphMovedSuccess").hidden = false;
                    })
                )
            }
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

        okParagraphAddRecipe.addEventListener('click', (function(e) {
            event.preventDefault();
            const idRecipe = document.querySelector('#idRecipe').value;
            var paragraphLines = document.querySelectorAll(".paragraphAddRecipeLine");
            console.log(paragraphLines);
            if (idRecipe != null) {
                var error = "";
                paragraphLines.forEach(element => saveParagraph(idRecipe, element).then((response) => {
                    if (response) {
                        if (response.success) {
                            element.setAttribute("data-id", response.id_paragraph)
                        } else {
                            console.log(response.errorMessages)
                            error = response.errorMessages;
                        }
                    }
                }))
                if (error == "") {
                    document.querySelector("#recipeParagraphSavedSuccess").hidden = false;
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
            content = element.childNodes[1].value;

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

<?php } else { ?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } ?>