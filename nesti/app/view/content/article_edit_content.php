<?php
if (!isset($article) || empty($article)) {
    $article = new Article();
}
if (!isset($errorMessages) || empty($errorMessages)) {
    $errorMessages = [];
}
?>

<div class="container bg-white align-items-left" id="recipePage">
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
                    <div class="col-3 p-0"><input type="text" class="form-control" name="stock" id="stock" value="<?= $article->getIdArticle() ?>" disabled></div>
                </div>
                <div class="d-flex flex-row">
                    <button id="submitEditArticle" type="submit" class="btn mr-5">Submit</button>
                    <button id="deleteEditArticle" type="reset" class="btn">Delete</button>
                </div>
            </form>
        </div>
        <div>
            <div id="pictureEdit" class="bg-light border mb-2"></div>

            <div class=" d-flex flex-row justify-content-between urlPictureEditArticle">
                <?= $article->getPicture()->getName() . $article->getPicture()->getExtension() ?>
                <a href="">
                    <div class="pictureBin"><img src="<?php echo BASE_URL . PATH_ICONS ?>delete-svg.svg" alt="svg bin"></div>
                </a>
            </div>
            <label class="form-label" for="customFile">Download a new picture</label>

            <div class="custom-file">
                <form id="formEditImage" action="" enctype="multipart/form-data" method="post">
                    <input type="file" class="custom-file-input" id="InputFileEditArticle" name="image">
                    <!-- le name dans le input se retrouve dans le $_FILES['image'] -->
                    <label class="custom-file-label" for="InputFileEditArticle" data-browse="Browse"></label>
                    <button type="submit">OK</button>
                </form>
            </div>


        </div>
    </div>
</div>

<script>
    // const ROOT = '<?= BASE_URL . PATH_AJAX ?>';
    const ROOT = '<?= BASE_URL ?>';
    const ROOTImage = '<?= BASE_URL . PATH_PICTURES ?>';

    const form = document.querySelector("#formEditImage");
    form.addEventListener('submit', (function(e) {
        event.preventDefault();
        console.log("test");
        const img = document.querySelector("#InputFileEditArticle")
        const id = document.querySelector("#idArticle").value;
        console.log(ROOT);
        if (img.value != "") {
            editPicture(id, this).then((response) => {
                if (response) {
                    if (response.success) {
                        console.log(response);
                        alert('edition picture ok');
                    }
                }
            });
        }

    }))
    // function editArticlePicture(obj) {
    //     console.log(obj)
    //     event.preventDefault();
    //     const img = document.querySelector("#InputFileEditArticle")
    //     const id = document.querySelector("#idArticle").value;
    //     console.log(ROOT);
    //     if (img.value != "") {
    //         editPicture(id, img.value).then((response) => {
    //             if (response) {
    //                 if (response.success) {
    //                     console.log(response);
    //                     alert('edition picture ok');
    //                 }
    //             }
    //         });
    //     }

    // }

    /**
     * Requete Ajax pour supprimer un tag d'une recette
     * @param {int} id_article
     * @returns mixed
     */
    async function editPicture(id_article, obj) {
        // Requete
        var myHeaders = new Headers();

        let formData = new FormData();
        console.log(obj);
        formData.append('image', obj);

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