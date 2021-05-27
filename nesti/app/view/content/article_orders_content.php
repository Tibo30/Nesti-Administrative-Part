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

<div class="container bg-light border d-flex flex-column align-items-left" id="ordersPage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp; > Orders</p>
    </div>
    <h2 class="mb-5 mt-5">Orders</h2>


    <div class="d-flex flex-row justify-content-center justify-content-lg-between flex-wrap">
        <div class="col-12 col-lg-8">
            <div class="d-flex flex-row justify-content-between">
                <nav class="navbar navbar-white bg-white pl-0">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" id="customSearchOrder" type="search" placeholder="Search" aria-label="Search">
                        <img id="searchOrder" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                    </form>
                </nav>

            </div>
            <table class="table-borderless table-striped" id="allOrdersTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchOrder" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
                <thead>
                    <tr>
                        <th>ID</th>

                        <th>User</th>

                        <th>Amount</th>

                        <th>Date</th>

                        <th>State</th>
                    </tr>
                </thead>
                <tbody id="allOrdersTbody">
                    <?php
                    foreach ($orders as $order) {
                        echo '<tr class="orders" data-id="' . $order->getIdOrder() . '">';
                        echo '<td>' . $order->getIdOrder() . '</td>';
                        echo '<td>' . $order->getUser()->getFirstName() . " " . $order->getUser()->getLastName() . '</td>';
                        echo '<td>' . round(($order->getAmount()), 2) . '</td>';
                        echo '<td>' . $order->getDisplayDate() . '</td>';
                        echo '<td>' . $order->getDisplayState() . '</td>';
                        echo '</tr>';
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column col-12 col-md-6 col-lg-4 ">
            <div class="d-flex flex-row flex-wrap justify-content-between">
                <h3>Details</h3>
                <div id="articleOrderId" class="d-flex justify-content-center align-items-center orderId">
                    <h4 id="idOrder">N°:</h4>
                </div>

            </div>

            <div id="listOrderLines" class="d-flex flex-column justify-content-start p-2 bg-white border">

            </div>


        </div>
    </div>
</div>

<script>
    const ROOT = '<?= BASE_URL ?>';
</script>