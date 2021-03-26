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

            <form method="post" id="addRecipeForm">
                <div class="form-group">
                    <label for="inputAddRecipeName">Recipe name</label>
                    <input type="text" class="form-control p-0" id="inputAddRecipeName" name="recipeName" value="">
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
                <div class="d-flex flex-row">
                    <button id="submitNewRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelNewRecipe" type="reset" class="btn">Cancel</button>
                </div>
            </form>
            <input type="text" class="form-control" name="idRecipe" id="idRecipe" value="" hidden>
        </div>

        <!-- changer le 2eme visible to invisible  -->
        <div class="invisible" id="addPicture">
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
                </form>
            </div>
        </div>
    </div>

    <!-- changer le 2eme visible to invisible  -->
    <div class="container px-0 mx-0 mt-5 bg-light d-flex flex-row justify-content-between invisible" id="hiddenContentAddRecipe">
        <div class="col-7">
            <h3 class="mb-2 mt-2">Preparation</h3>
            <div class="form-group">
                <div id="paragraphsAddRecipe" class="d-flex flex-column"></div>
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
                    <button id="okIngredientAddRecipe" type="submit" class="btn mr-5">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
    const ROOT = '<?= BASE_URL ?>';

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
                    alert("recipe added");
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
     * Ajax Request to edit the article picture
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
                        console.log(response)
                        console.log(divList);
                        console.log("test");
                        divList.innerHTML += response.recipeIngredient;
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

    // -------------------------------- Add paragraph --------------------------//  

    var order = 0;

    function addParagraph() {

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
        // paragraphLine.setAttribute('data-id', index);
        paragraphLine.setAttribute('order', order)

        // create the textarea element
        var textLine = document.createElement('textarea');
        textLine.className = "form-control mb-2 paragraphAddRecipe";
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

    function addListenerButtons() {
        // We add then evenListener on each svg type (still in the addParagraph listener because this is where there are created)
        var bins = document.querySelectorAll(".deleteSvg");
        if (bins != null) {
            bins.forEach(bin =>
                bin.addEventListener('click', function() {
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
                down.addEventListener('click',function() {
                    var currentParagraph=event.target.parentNode.parentNode;
                    console.log(event.target.parentNode.nextSibling.value);
                   
                    var currentOrder=Number(currentParagraph.getAttribute('order'))-1; // get the attribute to know its position in the list of paragraphs(order-1)
                    // currentParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) + 1);
                   
                    // var nextParagraph=event.target.parentNode.parentNode.nextSibling;
                    // nextParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) -1);

                    var paragraphLines = document.querySelectorAll(".paragraphAddRecipeLine"); // get the list of paragraphs
                    console.log( paragraphLines);
                    var test = paragraphLines;
                    console.log(test);
                    console.log("ok");
                    // var temp = paragraphLines[currentOrder]; // save the paragraph
                    // console.log(temp);
                    // console.log(paragraphLines[currentOrder+1]);
                    // paragraphLines[currentOrder]=paragraphLines[currentOrder+1];
                    // console.log(paragraphLines[currentOrder])
                    // paragraphLines[currentOrder+1]=temp;

                    console.log(Number(currentOrder)+1);
                    console.log(Number(currentOrder));
                    console.log(test[Number(currentOrder)+1]);
                    test[Number(currentOrder)+1]=paragraphLines[Number(currentOrder)];
                    test[Number(currentOrder)]=paragraphLines[Number(currentOrder)+1];
                    console.log(test);

                    var paragraphArea = document.querySelector("#paragraphsAddRecipe");
                    paragraphArea.innerHTML="";
                    paragraphLines.forEach(function(element) {
                        paragraphArea.appendChild(element);
                    });
                    addButtons(); // we do again the addButtons function
                })
            )
        }

        var ups = document.querySelectorAll(".upSvg");
        if (ups != null) {
            ups.forEach(up =>
                up.addEventListener('click',function() {
                    console.log("okUp")
                })
            )
        }
    }
</script>