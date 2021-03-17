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
        <div>
            <div class="d-flex flex-row justify-content-between">
                <nav class="navbar navbar-white bg-white pl-0">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" id="customSearchArticle" type="search" placeholder="Search" aria-label="Search">
                        <img id="searchArticle" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                    </form>
                </nav>

            </div>
            <table class="table-borderless table-striped tableOrder" rowEvents="" id="allArticleTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchArticle" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
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
                        echo '<tr class="orders" data-id="'. $order->getIdOrder().'">';
                        echo '<td>' . $order->getIdOrder() . '</td>';
                        echo '<td>' . $order->getUser()->getFirstName() . " " . $order->getUser()->getLastName() . '</td>';
                        echo '<td>' . round(($order->getAmount()), 2) . '</td>';
                        echo '<td>' . $order->getCreationDate() . '</td>';
                        echo '<td>' . $order->getState() . '</td>';
                        echo '</tr>';
                    } ?>
                </tbody>
                </tbody>
            </table>
        </div>

        <div>

            <h3>Details</h3>
            <div class="listOrderLines d-flex flex-column justify-content-between w-100 p-2 bg-white border">

            </div>


        </div>
    </div>
</div>

<script>
const ROOT = '<?= BASE_URL ?>';
    document.addEventListener("DOMContentLoaded", function() {

        const myTable=document.querySelector(".tableOrder"); // get the table
        myTable.addEventListener('click',function(){ // add event listener
            const orderId=event.target.parentNode.getAttribute('data-id'); // get the id of the parent node of the event target (td->tr)
            getOrderLines(orderId).then((response) => {
                if (response) {
                    const divList = document.querySelector(".listOrderLines")
                    if (response.success) {
                        response['articles'].forEach(element => {
                            const div = document.createElement("div");
                            div.innerHTML = element.quantity + " " + element.unitMeasure + " " + element.product + element.see;
                            divList.appendChild(div);
                        })
                    } else {
                        const div = document.createElement("div");
                        div.innerHTML ="";
                        divList.appendChild(div);
                    }
                   
                }
            });
        });

         /**
     * Ajax Request to edit the article picture
     * @param int orderId
     * @returns mixed
     */
    async function getOrderLines(orderId) {
        // Requete
        var myHeaders = new Headers();

        let formData = new FormData();
        formData.append('id_order',orderId);

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