<?php
if (!isset($article)||empty($article)) {
    $article = new Article();
}
?>

<div class="container bg-white align-items-left" id="recipePage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp > Edit</p>
    </div>
    <div class="d-flex flex-row justify-content-around">
        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">Article Edit</h2>
            <form>
                <div class="form-group">
                    <label for="articleFactoryName">Article factory name</label>
                    <input type="text" class="form-control p-0" id="articleFactoryName" value="<?= $article->getIdArticle() ?>">
                </div>
                <div class="form-group">
                    <label for="articleUserName">Article user name</label>
                    <input type="text" class="form-control p-0" id="articleUserName" value="<?= $article->getIdArticle() ?>">
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="idArticle">ID</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="idArticle" value="<?= $article->getIdArticle() ?>"></div>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="sellingPrice">Selling price</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="sellingPrice" value="<?= $article->getIdArticle() ?>"></div>
                </div>
                <div class="mx-0 p-0 form-group row justify-content-between">
                    <label for="stock">Stock</label>
                    <div class="col-2 p-0"><input type="text" class="form-control" id="stock" value="<?= $article->getIdArticle() ?>"></div>
                </div>
                <div class="d-flex flex-row">
                    <button id="submitEditArticle" type="submit" class="btn mr-5">Submit</button>
                    <button id="deleteEditArticle" type="reset" class="btn">Delete</button>
                </div>

            </form>
        </div>
        <div>
        <div id="pictureEdit" class="bg-light border mb-2"></div>
            <label class="form-label" for="customFile">Download a new picture</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="InputFile">
                <label class="custom-file-label" for="InputFile" data-browse="Browse"></label>
            </div>

        </div>
    </div>
</div>