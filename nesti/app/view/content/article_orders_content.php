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

<?php if (array_search("admin", $_SESSION["roles"]) === false) {

?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } else { ?>

<div class="container bg-light border d-flex flex-column align-items-left" id="ordersPage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>article"><u>Articles</u>
        </a>
        <p> &nbsp > Orders</p>
    </div>
    <h2 class="mb-5 mt-5">Orders</h2>


    <div class="d-flex flex-row justify-content-between flex-wrap">
        <div>
            <div class="d-flex flex-row justify-content-between">
                <nav class="navbar navbar-white bg-white pl-0">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" id="customSearchOrder" type="search" placeholder="Search" aria-label="Search">
                        <img id="searchOrder" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                    </form>
                </nav>

            </div>
            <table class="table-borderless table-striped" rowEvents="" id="allOrdersTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchOrder" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
                <thead>
                    <th>ID</th>

                    <th>User</th>

                    <th>Amount</th>

                    <th>Date</th>

                    <th>State</th>

                </thead>
                <tbody id="allOrdersTbody">
                    <?php
                    foreach ($orders as $order) {
                        echo '<tr class="orders" data-id="' . $order->getIdOrder() . '">';
                        echo '<td>' . $order->getIdOrder() . '</td>';
                        echo '<td>' . $order->getUser()->getFirstName() . " " . $order->getUser()->getLastName() . '</td>';
                        echo '<td>' . round(($order->getAmount()), 2) . '</td>';
                        echo '<td>' . $order->getDisplayDate() . '</td>';
                        echo '<td>' . $order->getState() . '</td>';
                        echo '</tr>';
                    } ?>
                </tbody>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column">
            <div class="d-flex flex-row flex-wrap justify-content-between">
                <h3>Details</h3>
                <div id="articleOrderId" class="d-flex justify-content-center align-items-center orderId">
                    <h4 id="idOrder" className="mr-5">N°:</h4>
                </div>

            </div>

            <div id="listOrderLines" class="d-flex flex-column justify-content-start p-2 bg-white border">

            </div>


        </div>
    </div>
</div>


<script>
    const ROOT = '<?= BASE_URL ?>';
    document.addEventListener("DOMContentLoaded", function() {

        // -------------------------------- Display articles for an order --------------------------//  

        const myTable = document.querySelector("#allOrdersTable"); // get the table
        myTable.addEventListener('click', function() { // add event listener
            var orderId = event.target.parentNode.getAttribute('data-id'); // get the id of the parent node of the event target (td->tr)
            getOrderLines(orderId).then((response) => {
                if (response) {
                    const divList = document.querySelector("#listOrderLines")
                    divList.innerHTML = "";
                    if (response.success) {
                        response['articles'].forEach(element => {
                            const div = document.createElement("div");
                            div.innerHTML = element.all;
                            divList.appendChild(div); // add the articles lines to the divList
                        })
                    } else {
                        const div = document.createElement("div");
                        div.innerHTML = "";
                        divList.appendChild(div); // if no response, empty the divList.
                    }
                    if (orderId == null) {
                        orderId = "";
                    }
                    document.querySelector("#idOrder").innerHTML = "N°: " + orderId;

                }
            });
        });

        /**
         * Ajax Request to get the articles from the orderLines according to the order
         * @param int orderId
         * @returns mixed
         */
        async function getOrderLines(orderId) {
            var myHeaders = new Headers();

            let formData = new FormData();
            formData.append('id_order', orderId);

            var myInit = {
                method: 'POST',
                headers: myHeaders,
                mode: 'cors',
                cache: 'default',
                body: formData
            };
            let response = await fetch(ROOT + 'article/order', myInit);
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

    });
</script>

<?php } ?>