<?php
if (!isset($article) || empty($article)) {
    $article = new Article();
}
if (!isset($errorMessages) || empty($errorMessages)) {
    $errorMessages = [];
}
?>

<?php if (array_search("admin", $_SESSION["roles"]) === false) {

?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } else { ?>

    <div class="container bg-white align-items-left position-relative" id="articleEditPage">
        <!-- div notif article edit -->
        <div id="articleEditSuccess" class="notifications" hidden>
            <p>The article has been successfully edited</p>
        </div>
        <!-- div notif picture article edit -->
        <div id="articlePictureEditSuccess" class="notifications" hidden>
            <p>The article picture has been successfully edited</p>
        </div>
        <div id="articlePictureEditMessage" class="notifications" hidden>
            <p></p>
        </div>
        <!-- div notif picture article delete -->
        <div id="articlePictureDeleteSuccess" class="notifications" hidden>
            <p>The article picture has been successfully deleted</p>
        </div>
        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>article"><u>Articles</u>
            </a>
            <p> &nbsp > Edit</p>
        </div>
        <h2 class="mb-2 mt-2">Article Edit</h2>
        <div class="d-flex flex-row justify-content-around flex-wrap">
            <div class="d-flex flex-column">
                <form method="post" action="" id="editArticleForm">
                    <div class="form-group">
                        <label for="articleFactoryName">Article factory name</label>
                        <input type="text" class="form-control p-0" name="articleFactoryName" id="articleFactoryName" value="<?= $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="articleUserName">Article user name</label>
                        <input type="text" class="form-control p-0" name="articleUserName" id="articleUserName" value="<?= $article->getUserArticleName() != null ? $article->getUserArticleName() : $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() ?>">
                        <span class="text-danger" id="errorEditArticleUserName"></span>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="idArticle">ID</label>
                        <div class="col-3 p-0"><input type="text" class="form-control" name="idArticle" id="idArticle" value="<?= $article->getIdArticle() ?>" disabled></div>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="sellingPrice">Selling price</label>
                        <div class="col-3 p-0"><input type="text" class="form-control" name="sellingPrice" id="sellingPrice" value="<?= round(($article->getPrice()->getPrice()), 2) ?>" disabled></div>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="stock">Stock</label>
                        <div class="col-3 p-0"><input type="text" class="form-control" name="stock" id="stock" value="<?= $article->getStock() ?>" disabled></div>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="inputArticleEditState">State</label> <br>
                        <select class="col-4 p-0" name="articleState" id="articleEditState">
                            <option value="a" <?php if ($article->getState() == 'a') {
                                                    echo 'selected';
                                                }; ?>>Active</option>
                            <option value="b" <?php if ($article->getState() == 'b') {
                                                    echo 'selected';
                                                }; ?>>Blocked</option>
                            <option value="w" <?php if ($article->getState() == 'w') {
                                                    echo 'selected';
                                                }; ?>>Waiting</option>
                        </select>
                    </div>
                    <div class="d-flex flex-row mb-3 mb-lg-0 justify-content-center">
                        <button id="submitEditArticle" data-toggle="modal" type="button" data-target="#modalEditArticle" class="btn mr-5">Submit</button>
                        <button id="cancelEditArticle" class="btn" type="reset">Cancel</button>
                    </div>
                    <div class="modal fade" id="modalEditArticle" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to update this article information ?</h5>
                                    <button type="button" class="close" id="closeModalEditArticle" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- <div class="modal-body">
                                                    ...
                                                </div> -->
                                <div class="modal-footer">
                                    <button id="confirm-edit-article" class="btn" type="submit">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <div id="articlePictureEdit" class="bg-light border mb-2 mt-2 mt-xl-0" style='background-image:url("<?= $article->getIdPicture() != null ? BASE_URL . PATH_PICTURES . $article->getPicture()->getName() . "." . $article->getPicture()->getExtension() : "" ?>")'></div>

                <div class=" d-flex flex-row justify-content-between">
                    <p class="articlePictureEditName"><?= $article->getIdPicture() != null ? ($article->getPicture()->getName() . "." . $article->getPicture()->getExtension()) : "" ?></p>

                    <div class="articlePictureBin" data-toggle="modal" data-target="#modalDeletePictureArticle"><img src="<?php echo BASE_URL . PATH_ICONS ?>delete-svg.svg" alt="svg bin"></div>

                    <div class="modal fade" id="modalDeletePictureArticle" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete this article picture ?</h5>
                                    <button type="button" class="close" id="closeModalDeletePictureArticle" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- <div class="modal-body">
                                                    ...
                                                </div> -->
                                <div class="modal-footer">
                                    <button id="confirm-delete-picture-article" class="btn" type="submit">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="form-label" for="customFile">Download a new picture</label>

                <div class="custom-file">
                    <form id="formEditArticleImage" action="" enctype="multipart/form-data" method="post">
                        <div class="d-flex flex-column">
                            <input type="file" class="custom-file-input" id="InputFileEditArticle" name="image">
                            <!-- le name dans le input se retrouve dans le $_FILES['image'] -->
                            <button data-toggle="modal" type="button" data-target="#modalEditPictureArticle" class="align-self-end mt-1 btn" id="btn-edit-article-picture">OK</button>
                        </div>
                        <label class="custom-file-label" for="InputFileEditArticle" data-browse="Browse"></label>
                        <input type="text" class="form-control" name="idArticlePicture" id="idArticlePicture" value="<?= $article->getIdArticle() ?>" hidden>
                        <div class="modal fade" id="modalEditPictureArticle" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to update this article picture ?</h5>
                                        <button type="button" class="close" id="closeModalEditPictureArticle" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- <div class="modal-body">
                                                    ...
                                                </div> -->
                                    <div class="modal-footer">
                                        <button id="confirm-edit-picture-article" class="btn" type="submit">Confirm</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>


    <script>
        const ROOT = '<?= BASE_URL ?>';

        // hide the notification after a click
        var notifs = document.querySelectorAll(".notifications");
        notifs.forEach(element =>
            element.addEventListener('click', (function(e) {
                element.hidden = true;
            }))
        )


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
    </script>

<?php } ?>