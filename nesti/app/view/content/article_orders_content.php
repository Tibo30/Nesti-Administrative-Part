<?php
if (!isset($orders)) {
    $orders = [];
    if (!empty($orders)) {
        foreach ($orders as $order) {
            $order = new Order();
        }
    }
}
?>

<div class="container bg-light border d-flex flex-column align-items-left" id="recipePage">
<div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp > Orders</p>
    </div>
    <h2 class="mb-5 mt-5">Orders</h2>

    <div class="d-flex flex-row justify-content-between">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchArticle" type="search" placeholder="Search" aria-label="Search">
                <img id="searchArticle" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
            </form>
        </nav>

    </div>

    <table class="table-borderless table-striped" id="allArticleTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchArticle" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
        <thead>
            <th>ID</th>

            <th>User</th>

            <th>Amount</th>

            <th>Date</th>

            <th>State</th>

        </thead>
        <tbody id="allArticleTbody">
            <?php
            foreach ($orders as $order) {
                echo '<tr>';
                echo '<td>' . $order->getIdOrder() . '</td>';
                echo '<td>' . $order->getUser()->getFirstName()." " . $order->getUser()->getLastName() . '</td>';
                echo '<td>' . round(($order->getAmount()), 2) . '</td>';
                echo '<td>' . $order->getCreationDate() . '</td>';
                echo '<td>' . $order->getState() . '</td>';
                echo '</tr>';
            } ?>
        </tbody>
        </tbody>
    </table>
</div>