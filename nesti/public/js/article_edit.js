// hide the notification after a click
var notifs = document.querySelectorAll(".notifications");
notifs.forEach(element =>
    element.addEventListener('click', (function(e) {
        element.hidden = true;
    }))
)

function updatePictureName() {
    var input = document.querySelector("#InputFileEditArticle");
    var output = document.querySelector('.pictureNameInput');
    output.innerHTML = input.files.item(0).name;
}


// -------------------------------- Edit article --------------------------//  

var formEditArticle = document.querySelector("#editArticleForm"); // get the form used to edit the recipe
// Event listener on the form
formEditArticle.addEventListener('submit', (function(e) {
    event.preventDefault(); // stop the default action of the form
    const idArticle = document.querySelector('#idArticle').value;
    editArticle(this, idArticle).then((response) => {
        if (response) {
            if (response.success) {
                document.querySelector("#articleFactoryName").value = response.articleFactoryName;
                document.querySelector("#articleUserName").value = response.articleUserName;
                document.querySelector("#idArticle").value = response.idArticle;
                document.querySelector("#sellingPrice").value = response.articlePrice;
                document.querySelector("#stock").value = response.articleStock;
                if (response.articleState == "a") {
                    document.querySelector("#articleEditState").options.selectedIndex = 0;
                } else if (response.articleState == "b") {
                    document.querySelector("#articleEditState").options.selectedIndex = 1;
                } else if (response.articleState == "w") {
                    document.querySelector("#articleEditState").options.selectedIndex = 2;
                }

                document.querySelector("#errorEditArticleUserName").innerHTML = "";
                document.querySelector("#articleEditSuccess").hidden = false;
            } else {
                document.querySelector("#errorEditArticleUserName").innerHTML = response.errorMessages['articleUserName'];
            }
            document.querySelector("#closeModalEditArticle").click();
        }
    });
}))

/**
 * Ajax Request to edit the article
 * @param {form} obj, int idArticle
 * @returns mixed
 */
async function editArticle(obj, idArticle) {
    var myHeaders = new Headers();

    let formData = new FormData(obj);
    formData.append('id_article', idArticle);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'article/editarticle', myInit);
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

const deleteButton = document.querySelector("#confirm-delete-picture-article");
deleteButton.addEventListener('click', (function(e) {
    event.preventDefault();
    const idArticle = document.querySelector('#idArticle').value;
    if (idArticle != null) {
        deletePicture(idArticle).then((response) => {
            if (response) {
                if (response.success) {
                    const namePicture = document.querySelector(".articlePictureEditName"); // get the paragraph where the name of the picture is written
                    const divPicture = document.querySelector("#articlePictureEdit"); // get the div where the picture is displayed
                    namePicture.innerHTML = ""; // change the name of the picture to empty
                    divPicture.style.backgroundImage = null; // change the background image of the div to null
                    document.querySelector("#articlePictureDeleteSuccess").hidden = false;
                }
            }
            document.querySelector("#closeModalDeletePictureArticle").click();
        });
    }
}))

/**
 * Ajax Request to delete the article picture
 * @param int idArticle
 * @returns mixed
 */
async function deletePicture(idArticle) {
    var myHeaders = new Headers();

    let formData = new FormData();
    formData.append('id_article', idArticle);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'article/deletepicture', myInit);
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

// -------------------------------- Edit article picture --------------------------//   

const form = document.querySelector("#formEditArticleImage"); // get the form used to edit the picture
// Event listener on the form
form.addEventListener('submit', (function(e) {
    event.preventDefault(); // stop the default action of the form
    const img = document.querySelector("#InputFileEditArticle")
    if (img.value != "") {
        editPicture(this).then((response) => {
            if (response) {
                if (response.success) {
                    const namePicture = document.querySelector(".articlePictureEditName"); // get the paragraph where the name of the picture is written
                    const divPicture = document.querySelector("#articlePictureEdit"); // get the div where the picture is displayed
                    namePicture.innerHTML = response["picture"]; // change the name of the picture
                    divPicture.style.backgroundImage = "url(" + response["urlPicture"] + ")"; // change the background image of the div with the new picture
                    if (response.MessageDb != null) { // if there is a message from the Db (if the name of the picture is already taken)
                        document.querySelector("#articlePictureEditMessage").hidden = false;
                        document.querySelector("#articlePictureEditMessage").innerHTML = "<p>" + response.MessageDb + "</p>";
                    } else {
                        document.querySelector("#articlePictureEditSuccess").hidden = false;
                    }
                } else {
                    if (response.errorMove != null) { // if the picture has not been moved
                        alert(response.errorMove);
                    }
                }
            }
            document.querySelector("#closeModalEditPictureArticle").click();
        });
    }

}))

/**
 * Ajax Request to edit the article picture
 * @param {form} obj
 * @returns mixed
 */
async function editPicture(obj) {
    var myHeaders = new Headers();

    let formData = new FormData(obj);

    var myInit = {
        method: 'POST',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default',
        body: formData
    };
    let response = await fetch(ROOT + 'article/picture', myInit);
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