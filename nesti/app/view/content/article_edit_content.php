<?php
if (!isset($article) || empty($article)) {
    $article = new Article();
}
if (!isset($errorMessages) || empty($errorMessages)) {
    $errorMessages = [];
}
?>

<div class="container bg-white align-items-left" id="articleEditPage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp > Edit</p>
    </div>
    <h2 class="mb-2 mt-2">Article Edit</h2>
    <div class="d-flex flex-row justify-content-around flex-wrap">
        <div class="d-flex flex-column">
            <form method="post" action="">
                <div class="form-group">
                    <label for="articleFactoryName">Article factory name</label>
                    <input type="text" class="form-control p-0" name="articleFactoryName" id="articleFactoryName" value="<?= $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="articleUserName">Article user name</label>
                    <input type="text" class="form-control p-0" name="articleUserName" id="articleUserName" value="<?= $article->getUserArticleName() != null ? $article->getUserArticleName() : $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() ?>">
                    <?php if (array_key_exists('articleUserNameError', $errorMessages)) : ?>
                        <span class="text-danger"><?php $errorMessages['articleUserNameError']; ?></span>
                    <?php endif; ?>
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
                <div class="d-flex flex-row">
                    <button id="submitEditArticle" type="submit" class="btn mr-5">Submit</button>
                    <!-- <button id="deleteEditArticle" type="reset" class="btn">Delete</button> -->
                </div>
            </form>
        </div>
        <div>
            <div id="articlePictureEdit" class="bg-light border mb-2" style='background-image:url("<?= $article->getIdPicture() != null ? BASE_URL . PATH_PICTURES . $article->getPicture()->getName() . "." . $article->getPicture()->getExtension() : "" ?>")'></div>

            <div class=" d-flex flex-row justify-content-between">
                <p class="articlePictureEditName"><?= $article->getIdPicture() != null ? ($article->getPicture()->getName() . "." . $article->getPicture()->getExtension()) : "" ?></p>
                <a id="deletePictureButton" href="">
                    <div class="articlePictureBin"><img src="<?php echo BASE_URL . PATH_ICONS ?>delete-svg.svg" alt="svg bin"></div>
                </a>
            </div>
            <label class="form-label" for="customFile">Download a new picture</label>

            <div class="custom-file">
                <form id="formEditArticleImage" action="" enctype="multipart/form-data" method="post">
                    <div class="d-flex flex-column"> 
                        <input type="file" class="custom-file-input" id="InputFileEditArticle" name="image">
                        <!-- le name dans le input se retrouve dans le $_FILES['image'] -->
                        <button type="submit" class="align-self-end mt-1 btn" id="btn-edit-article-picture">OK</button>
                    </div>
                    <label class="custom-file-label" for="InputFileEditArticle" data-browse="Browse"></label>
                    <input type="text" class="form-control" name="idArticlePicture" id="idArticlePicture" value="<?= $article->getIdArticle() ?>" hidden>

                </form>
            </div>


        </div>
    </div>
</div>

<script>
    const ROOT = '<?= BASE_URL ?>';

    const deleteButton = document.querySelector("#deletePictureButton");
    deleteButton.addEventListener('click', (function(e) {
        event.preventDefault();
        const idArticle = document.querySelector('#idArticle').value;
        console.log(idArticle);
        if (idArticle != null) {
            deletePicture(idArticle).then((response) => {
                if (response) {
                    if (response.success) {
                        const namePicture = document.querySelector(".articlePictureEditName"); // get the paragraph where the name of the picture is written
                        const divPicture = document.querySelector("#articlePictureEdit"); // get the div where the picture is displayed
                        namePicture.innerHTML = ""; // change the name of the picture to empty
                        divPicture.style.backgroundImage = null; // change the background image of the div to null
                        alert('Picture deleted');
                    }
                }
            });
        }
    }))

    /**
     * Ajax Request to edit the article picture
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