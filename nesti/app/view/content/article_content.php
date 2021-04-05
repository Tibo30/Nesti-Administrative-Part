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

<?php if (array_search("admin", $_SESSION["roles"]) === false) {

?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } else { ?>

<div class="container d-flex flex-column align-items-left position-relative" id="allArticlesPage">
    <!-- div notif article delete -->
    <div id="articleDeletedSuccess" class="notifications" hidden>
        <p>The article has been deleted (blocked)</p>
    </div>
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
                echo '<td>' . $article->getDisplayState() . '</td>';
                echo '<td>' . $article->getStock() . '</td>';
                echo '<td>';
                echo '<a class="btn-modify-article" href="' . BASE_URL . 'article/edit/' .  $article->getIdArticle() . ' "data-id=' . $article->getIdArticle() . '>Modify</br></a>';
                echo '<a class="btn-delete-article" data-id=' . $article->getIdArticle() . ' data-toggle="modal" data-target="#modalDeleteArticle' . $article->getIdArticle() . '">Delete</a>';
                echo '</td>';
                echo '</tr>';
                echo '  <div class="modal fade" id="modalDeleteArticle' . $article->getIdArticle() . '" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete this article ?</h5>
                            <button type="button" class="close" id="closeModalDelete' . $article->getIdArticle() . '" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- <div class="modal-body">
                                                            ...
                                                        </div> -->
                        <div class="modal-footer">
                            <button id="confirm-delete-article" type="button" class="btn" data-id="' . $article->getIdArticle() . '" onclick="allArticlesDelete()" s>Confirm</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>';
            } ?>
        </tbody>
    </table>
</div>

<?php } ?>

<script>
    const ROOT = '<?= BASE_URL ?>';

    // hide the notification after a click
    var notifs = document.querySelectorAll(".notifications");
    notifs.forEach(element =>
        element.addEventListener('click', (function(e) {
            element.hidden = true;
        }))
    )

    function allArticlesDelete() {
        let idArticle = event.target.getAttribute('data-id');
        deleteArticle(idArticle).then((response) => {
            if (response) {
                if (response.success) {
                    const tbody = document.querySelector("#allArticlesTbody");
                    tbody.innerHTML = ""; // we empty the tbody
                    // then we fill it with the new articles got from the fetch
                    response['articles'].forEach(element => {
                        const tr = document.createElement("tr");
                        tr.innerHTML = "<td>" + element.id + "</td><td>" + element.name + "</td><td>" + element.selling_price + "</td><td>" + element.type + "</td><td>" + element.last_import + "</td><td>" + element.state + "</td><td>" + element.stock + "</td><td>" + element.action + "</td>";
                        tbody.appendChild(tr); // We add the new lines to the tbody
                    })
                    document.querySelector("#closeModalDelete" + idArticle).click();
                    document.querySelector("#articleDeletedSuccess").hidden = false;
                }
            }
        })
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