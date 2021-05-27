<?php
if (!isset($article) || empty($article)) {
    $article = new Article();
}
?>

    <div class="container bg-white align-items-left position-relative" id="articleEditPage">
        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>article"><u>Articles</u>
            </a>
            <p> &nbsp; > Edit</p>
        </div>
        <h2 class="mb-2 mt-2">Article Edit</h2>
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
        <div class="d-flex flex-row justify-content-around flex-wrap">
            <div class="d-flex flex-column">
                <form method="post" id="editArticleForm">
                    <div class="form-group">
                        <label for="articleFactoryName">Article factory name</label>
                        <input type="text" class="form-control p-0" name="articleFactoryName" id="articleFactoryName" value="<?= $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " of " .  $article->getProduct()->getProductName() ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="articleUserName">Article user name</label>
                        <input type="text" class="form-control p-0" name="articleUserName" id="articleUserName" value="<?= $article->getUserArticleName() != null ? $article->getUserArticleName() : $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " of " .  $article->getProduct()->getProductName() ?>">
                        <span class="text-danger" id="errorEditArticleUserName"></span>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="idArticle">ID</label>
                        <div class="col-3 p-0"><input type="text" class="form-control" name="idArticle" id="idArticle" value="<?= $article->getIdArticle() ?>" disabled></div>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="sellingPrice">Selling price</label>
                        <div class="col-3 p-0"><input type="text" class="form-control" name="sellingPrice" id="sellingPrice" value="<?= $article->getPrice() != null ? round(($article->getPrice()->getPrice()), 2) : "" ?>" disabled></div>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="stock">Stock</label>
                        <div class="col-3 p-0"><input type="text" class="form-control" name="stock" id="stock" value="<?= $article->getStock() ?>" disabled></div>
                    </div>
                    <div class="mx-0 p-0 form-group row justify-content-between">
                        <label for="articleEditState">State</label> <br>
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
                    <div class="modal fade" id="modalEditArticle" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitleEditArticle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalCenterTitleEditArticle">Do you really want to update this article information ?</h5>
                                    <button type="button" class="close" id="closeModalEditArticle" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
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

                    <div class="modal fade" id="modalDeletePictureArticle" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitleDeletePicture" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalCenterTitleDeletePicture">Do you really want to delete this article picture ?</h5>
                                    <button type="button" class="close" id="closeModalDeletePictureArticle" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button id="confirm-delete-picture-article" class="btn" type="submit">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="form-label" for="InputFileEditArticle">Download a new picture</label>

                <div class="custom-file">
                    <form id="formEditArticleImage" enctype="multipart/form-data" method="post">
                        <div class="d-flex flex-column">
                            <input type="file" class="custom-file-input" id="InputFileEditArticle" name="image" onchange="updatePictureName()">
                            <div class="d-flex align-items-center justify-content-end">
                                <p class="pictureNameInput w-100"></p>
                                <button data-toggle="modal" type="button" data-target="#modalEditPictureArticle" class="align-self-end mt-1 btn" id="btn-edit-article-picture">OK</button>
                            </div>
                        </div>
                        <label class="custom-file-label" for="InputFileEditArticle" data-browse="Browse"></label>
                        <input type="text" class="form-control" name="idArticlePicture" id="idArticlePicture" value="<?= $article->getIdArticle() ?>" hidden>
                        <div class="modal fade" id="modalEditPictureArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to update this article picture ?</h5>
                                        <button type="button" class="close" id="closeModalEditPictureArticle" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
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
    </script>