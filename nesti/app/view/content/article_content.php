<?php
if (!isset($articles)) {
    $articles = [];
    if (!empty($articles)) {
        foreach ($articles as $article) {
            $article = new Article();
        }
    }
}
?>

<div class="container bg-light border d-flex flex-column align-items-left" id="recipePage">
    <h2 class="mb-5 mt-5">Article</h2>

    <div class="d-flex flex-row justify-content-between">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchArticle" type="search" placeholder="Search" aria-label="Search">
                <img id="searchArticle" src="<?php echo BASE_URL ?>public/pictures/search-svg.svg" alt="">
            </form>
        </nav>
        <div>
            <a id="btnSeeOrders" href="article/orders" class="btn mb-1 border align-self-end"> <i class="fa fa-eye mr-2"></i>
                Orders</a>
            <a id="btnAddArticle" href="article/import" class="btn mb-1 border align-self-end"> <img id="addArticle" src="<?php echo BASE_URL ?>public/pictures/create-svg.svg" alt="svg plus">
                Import</a>
        </div>

    </div>

    <table class="table-borderless table-striped" id="table" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchArticle" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
        <thead>
            <th>ID</th>

            <th>Name</th>

            <th>Selling Price</th>

            <th>Type</th>

            <th>Last import</th>

            <th>Stock</th>

            <th>Actions</th>
        </thead>
        <tbody>
            <?php
            foreach ($articles as $article) {
                echo '<tr>';
                echo '<td>' . $article->getIdArticle() . '</td>';
                echo '<td>' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() . '</td>';
                echo '<td>' . round(($article->getPrice()->getPrice()), 2) . '</td>';
                echo '<td>' . $article->getType() . '</td>';
                echo '<td>' . $article->getLastImport()->getImportDate() . '</td>';
                echo '<td>' . "Stock" . '</td>';
                echo '<td>';
                echo '<a href="' . BASE_URL . 'article/edit/' .  $article->getIdArticle() . ' "data-id='.$article->getIdArticle().'>Modify</br></a>';
                echo '<a href="' . BASE_URL . 'article/delete/' .  $article->getIdArticle() . ' "data-id='.$article->getIdArticle().'>Delete</a>';
                echo '</td>';
                echo '</tr>';
            } ?>
        </tbody>
        </tbody>
    </table>
</div>