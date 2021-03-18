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

<div class="container bg-light border d-flex flex-column align-items-left" id="allArticlesPage">
    <h2 class="mb-5 mt-5">Article</h2>

    <div class="d-flex flex-row justify-content-between">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchArticle" type="search" placeholder="Search" aria-label="Search">
                <img id="searchArticle" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
            </form>
        </nav>
        <div>
            <a id="btnSeeOrders" href="article/orders" class="btn mb-1 border align-self-end"> <i class="fa fa-eye mr-2"></i>
                Orders</a>
            <a id="btnImportArticle" href="article/import" class="btn mb-1 border align-self-end"> <img id="svgImportArticle" src="<?php echo BASE_URL . PATH_ICONS ?>create-svg.svg" alt="svg plus">
                Import</a>
        </div>

    </div>

    <table class="table-borderless table-striped" id="allArticlesTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchArticle" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
        <thead>
            <th>ID</th>

            <th>Name</th>

            <th>Selling Price</th>

            <th>Type</th>

            <th>Last import</th>

            <th>State</th>

            <th>Stock</th>

            <th>Actions</th>
        </thead>
        <tbody id="allArticlesTbody">
            <?php
            foreach ($articles as $article) {
                echo '<tr>';
                echo '<td>' . $article->getIdArticle() . '</td>';
                echo '<td>' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " de " .  $article->getProduct()->getProductName() . '</td>';
                echo '<td>' . round(($article->getPrice()->getPrice()), 2) . '</td>';
                echo '<td>' . $article->getType() . '</td>';
                echo '<td>' . $article->getLastImport()->getImportDate() . '</td>';
                echo '<td>' . $article->getState() . '</td>';
                echo '<td>' . $article->getStock() . '</td>';
                echo '<td>';
                echo '<a id="allArticlesModify" class="btn-modify-article" href="' . BASE_URL . 'article/edit/' .  $article->getIdArticle() . ' "data-id=' . $article->getIdArticle() . '>Modify</br></a>';
                echo '<a id="allArticlesDelete" class="btn-delete-article" onclick="allArticlesDelete()" data-id=' . $article->getIdArticle() . '>Delete</a>';
                echo '</td>';
                echo '</tr>';
            } ?>
        </tbody>
        </tbody>
    </table>
</div>

<script>
    const ROOT = '<?= BASE_URL ?>';

    function allArticlesDelete() {
        let idArticle = event.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this article ?')) {
            deleteArticle(idArticle).then((response) => {
                if (response) {
                    if (response.success) {
                        const tbody = document.querySelector("#allArticlesTbody");
                        tbody.innerHTML=""; // we empty the tbody
                        // then we fill it with the new articles got from the fetch
                        response['articles'].forEach(element => {
                            const tr = document.createElement("tr");
                            tr.innerHTML = "<td>" + element.id + "</td><td>" + element.name + "</td><td>" + element.selling_price + "</td><td>" + element.type + "</td><td>" + element.last_import + "</td><td>" + element.state + "</td><td>" + element.stock + "</td><td>" + element.action + "</td>";
                            tbody.appendChild(tr); // We add the new lines to the tbody
                        })
                        alert('This article has been deleted from the database !');
                    }
                }
            })
        } else {
            alert('The article has not been deleted from the database !');
        }
    }


     /**
     * Ajax Request to delete the Article (change the status to blocked)
     * @param int idArticle
     * @returns mixed
     */
    async function deleteArticle(idArticle) {

        var myHeaders = new Headers();

        let formData = new FormData();
        formData.append('idArticle', idArticle);
        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        
        // Use the fetch API to access the database (the method is called in the ArticleController)
        let response = await fetch(ROOT + 'article/delete', myInit);
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