<?php if (array_search("admin", $_SESSION["roles"]) === false) {

?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } else { ?>

<div class="container bg-white align-items-left" id="importArticlePage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp > Import</p>
    </div>
    <div class="d-flex flex-row justify-content-center justify-content-lg-around flex-wrap ">
        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">Import</h2>
            <form method="post">
                <label class="form-label" for="importCSV">Import a .CSV File</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="importCSV">
                    <label class="custom-file-label" for="importCSV" data-browse=""></label>
                </div>
            </form>
            <button class="btn mt-2 align-self-end" id="importArticle">Import</button>

        </div>
        <div>
            <div class="d-flex flex-column">
                <h3 class="mb-3 mt-3 mt-lg-0">List of imported articles</h2>
                    <div class="d-flex flex-column justify-content-between w-100 p-2 bg-white border">
                        <?php foreach ($articles as $article) {
                            echo ' <div class="d-flex flex-row justify-content-between"> <p> ' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() . '</p><p>'.$article->getQuantityBought() . ' </p><div><a href="' . BASE_URL . 'article/edit/' . $article->getIdArticle() . '" class="btn-edit-article">Edit</a></div></div>';
                        }
                        ?>
                    </div>

            </div>

        </div>

    </div>

</div>

<?php } ?>