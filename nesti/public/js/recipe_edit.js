// hide the notification after a click
var notifs = document.querySelectorAll(".notifications");
notifs.forEach(element =>
    element.addEventListener('click', (function(e) {
        element.hidden = true;
    }))
)

function updatePictureName() {
    var input = document.querySelector("#InputFileEditRecipe");
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
        'class = "close" id = "closeModalEditRecipeDeleteIngredient' + idIngredient + '" data-dismiss = "modal" aria-label = "Close"> ' +
        '<span aria-hidden="true"> &times; </span> </button> </div>  <div class = "modal-footer" >' +
        '<button id = "confirm-edit-recipe-delete-ingredient" type = "button" class = "btn"> Confirm </button> ' +
        '<button type = "button" class = "btn btn-danger" data-dismiss = "modal" > Cancel </button> </div> </div> </div> </div>';

    divModal.innerHTML = newModal;
    line.appendChild(divModal); // add the div to the ingredient line

    var opener = document.getElementById("openModalIngredient" + Number(order)); // get the hidden div that can open the modal
    opener.click(); // simulate a click on this button

    var confirmDeleteIngredient = document.querySelector("#confirm-edit-recipe-delete-ingredient");
    if (confirmDeleteIngredient != null) {
        confirmDeleteIngredient.addEventListener('click', function() {
            listenerDeleteIngredient(order, idRecipe, idIngredient)
            document.querySelector("#closeModalEditRecipeDeleteIngredient" + idIngredient).click(); // simulate a click on the close modal button
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
                if (response.recipeState == "a") {
                    document.querySelector("#recipeEditState").options.selectedIndex = 0;
                } else if (response.recipeState == "b") {
                    document.querySelector("#recipeEditState").options.selectedIndex = 1;
                } else if (response.recipeState == "w") {
                    document.querySelector("#recipeEditState").options.selectedIndex = 2;
                }

                document.querySelector("#errorEditRecipeName").innerHTML = "";
                document.querySelector("#errorEditDifficulty").innerHTML = "";
                document.querySelector("#errorEditNumberPeople").innerHTML = "";
                document.querySelector("#errorEditTime").innerHTML = "";

                document.querySelector("#idRecipe").value = response.idRecipe;
                document.querySelector("#recipeEditSuccess").hidden = false;
            } else {
                document.querySelector("#errorEditRecipeName").innerHTML = response.errorMessages['recipeName'];
                document.querySelector("#errorEditDifficulty").innerHTML = response.errorMessages['difficulty'];
                document.querySelector("#errorEditNumberPeople").innerHTML = response.errorMessages['numberOfPeople'];
                document.querySelector("#errorEditTime").innerHTML = response.errorMessages['preparationTime'];
            }
        }
        document.querySelector("#closeModalEditRecipe").click();
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
                    const namePicture = document.querySelector(".recipePictureEditName"); // get the paragraph where the name of the picture is written
                    const divPicture = document.querySelector("#recipePictureEdit"); // get the div where the picture is displayed
                    namePicture.innerHTML = response["picture"]; // change the name of the picture
                    divPicture.style.backgroundImage = "url(" + response["urlPicture"] + ")"; // change the background image of the div with the new picture
                    if (response.MessageDb != null) { // if there is a message from the Db (if the name of the picture is already taken)
                        document.querySelector("#recipePictureEditMessage").hidden = false;
                        document.querySelector("#recipePictureEditMessage").innerHTML = "<p>" + response.MessageDb + "</p>";
                    } else {
                        document.querySelector("#recipePictureEditSuccess").hidden = false;
                    }
                } else {
                    if (response.errorMove != null) { // if the picture has not been moved
                        alert(response.errorMove);
                    }
                }
            }
            document.querySelector("#closeModalEditPictureRecipe").click();
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

// -------------------------------- Delete recipe picture --------------------------//  

const deleteButton = document.querySelector("#confirm-delete-picture-recipe");
deleteButton.addEventListener('click', (function(e) {
    event.preventDefault();
    const idRecipe = document.querySelector('#idRecipe').value;
    if (idRecipe != null) {
        deletePicture(idRecipe).then((response) => {
            if (response) {
                if (response.success) {
                    const namePicture = document.querySelector(".recipePictureEditName"); // get the paragraph where the name of the picture is written
                    const divPicture = document.querySelector("#recipePictureEdit"); // get the div where the picture is displayed
                    namePicture.innerHTML = ""; // change the name of the picture to empty
                    divPicture.style.backgroundImage = null; // change the background image of the div to null
                    document.querySelector("#recipePictureDeleteSuccess").hidden = false;
                }
            }
            document.querySelector("#closeModalDeletePictureRecipe").click();
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
                    document.querySelector("#errorRecipeEditQuantity").innerHTML = "";
                    document.querySelector("#errorRecipeEditIngredient").innerHTML = "";
                    document.querySelector("#errorRecipeEditUnit").innerHTML = "";

                    document.querySelector("#inputIngredientNameEditRecipe").value = "";
                    document.querySelector("#inputIngredientQuantityEditRecipe").value = "";
                    document.querySelector("#inputIngredientUnitEditRecipe").value = "";

                    document.querySelector("#recipeEditIngredientEditSuccess").hidden = false;
                } else {
                    document.querySelector("#errorRecipeEditQuantity").innerHTML = response.errorMessages['quantity'];
                    document.querySelector("#errorRecipeEditIngredient").innerHTML = response.errorMessages['productName'];
                    document.querySelector("#errorRecipeEditUnit").innerHTML = response.errorMessages['unitName'];
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


function listenerDeleteIngredient(order, idRecipe, idIngredient) {
    event.preventDefault();
    var divList = document.querySelector("#addIngredientListEditRecipe");

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
                    document.querySelector("#recipeEditIngredientDeletedSuccess").hidden = false;
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

    document.querySelector("#recipeEditParagraphMovedSuccess").hidden = false;

    createEntitiesParagraph();

    addButtons();
}

/**
 * This function create all the elements needed for the paragraph (div, textareas)
 */
function createEntitiesParagraph() {
    paragraphs = document.querySelectorAll(".paragraphEditRecipeLine")
    order = 0;
    if (paragraphs.length > 0) {
        order = paragraphs[paragraphs.length - 1].getAttribute('order');
    }
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
    // We add then evenListener down and up svg (still in the addParagraph listener because this is where there are created)
    var downs = document.querySelectorAll(".downSvg");
    if (downs != null) {
        downs.forEach(down =>
            down.addEventListener('click', function() {
                var currentParagraph = event.target.parentNode.parentNode;
                console.log(currentParagraph);

                var currentOrder = Number(currentParagraph.getAttribute('order')) - 1; // get the attribute to know its position in the list of paragraphs(order-1)
                currentParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) + 1);
                var nextParagraph = event.target.parentNode.parentNode.nextElementSibling;

                nextParagraph.setAttribute('order', Number(currentParagraph.getAttribute('order')) - 1);

                var paragraphLines = document.querySelectorAll(".paragraphEditRecipeLine"); // get the list of paragraphs

                paragraphLines[currentOrder].parentNode.insertBefore(paragraphLines[currentOrder], paragraphLines[currentOrder + 1].nextSibling); // = insert after

                addButtons(); // we do again the addButtons function
                document.querySelector("#recipeEditParagraphMovedSuccess").hidden = false;
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
                document.querySelector("#recipeEditParagraphMovedSuccess").hidden = false;
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
            document.querySelector("#recipeEditParagraphSavedSuccess").hidden = false;
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