<?php
if (!isset($articles)) {
    $articles = [];
    $article = new Article();
    $articles[] = $article;
}
?>
<div class="container d-flex flex-column align-items-left position-relative" id="allArticlesPage">
    <h2 class="mb-2 mt-3">Articles</h2>
    <!-- div notif article delete -->
    <div id="articleDeletedSuccess" class="notifications" hidden>
        <p>The article has been deleted (blocked)</p>
    </div>
    <div class="d-flex flex-row justify-content-xl-between justify-content-center flex-wrap">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchArticle" type="search" placeholder="Search" aria-label="Search">
                <img id="searchArticle" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
            </form>
        </nav>
        <div class="pt-2">
            <a id="btnSeeOrders" href="article/orders" class="btn border align-self-end"> <i class="fa fa-eye mr-2"></i>
                Orders</a>
            <a id="btnImportArticle" href="article/import" class="btn border align-self-end"> <img id="svgImportArticle" src="<?php echo BASE_URL . PATH_ICONS ?>create-svg.svg" alt="svg plus">
                Import</a>
        </div>

    </div>

    <table class="table-borderless table-striped" id="allArticlesTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchArticle" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
        <thead>
            <tr>
                <th>ID</th>

                <th>Name</th>

                <th>Selling Price</th>

                <th>Type</th>

                <th>Last import</th>

                <th>State</th>

                <th>Stock</th>

                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="allArticlesTbody">
            <?php
            foreach ($articles as $article) {
                echo '<tr>';
                echo '<td>' . $article->getIdArticle() . '</td>';
                echo '<td>' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " of " .  $article->getProduct()->getProductName() . '</td>';
                echo '<td>' . ($article->getPrice() != null ? round(($article->getPrice()->getPrice()), 2) : "") . ' € </td>';
                echo '<td>' . $article->getType() . '</td>';
                echo '<td>' . $article->getLastImport()->getDisplayDate() . '</td>';
                echo '<td>' . $article->getDisplayState() . '</td>';
                echo '<td>' . $article->getStock() . '</td>';
                echo '<td>';
                echo '<a class="btn-modify-article" href="' . BASE_URL . 'article/edit/' .  $article->getIdArticle() . ' " data-id=' . $article->getIdArticle() . '>Modify<br></a>';
                echo '<a class="btn-delete-article" data-id=' . $article->getIdArticle() . ' data-toggle="modal" data-target="#modalDeleteArticle' . $article->getIdArticle() . '">Delete</a>';
                echo '  <div class="modal fade" id="modalDeleteArticle' . $article->getIdArticle() . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle' . $article->getIdArticle() . '" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle' . $article->getIdArticle() . '">Do you really want to delete this article ?</h5>
                            <button type="button" class="close" id="closeModalDelete' . $article->getIdArticle() . '" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- <div class="modal-body">
                                                            ...
                                                        </div> -->
                        <div class="modal-footer">
                            <button type="button" class="btn confirm-delete-article" data-id="' . $article->getIdArticle() . '" onclick="allArticlesDelete()">Confirm</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>';
                echo '</td>';
                echo '</tr>';
            } ?>
        </tbody>
    </table>
</div>

<script>
    const ROOT = '<?= BASE_URL ?>';
</script>