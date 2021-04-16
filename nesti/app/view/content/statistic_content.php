<?php if (array_search("admin", $_SESSION["roles"]) === false) {

?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } else { ?>
    <div id="statisticsPage" class="">
        <div class="d-flex flex-column">
            <h1>Stats</h1>

            <div class="d-flex flex-row flex-wrap justify-content-lg-between justify-content-center">
                <div class="d-flex flex-column col-12 col-lg-5">
                    <h2>Orders</h2>
                    <div id="toastOrders"> </div>
                    <p class="statistic_titles">Biggest orders</p>
                    <div id="biggestOrders" class="border p-3">
                        <?php foreach ($biggestOrders as $biggestOrder) {
                            echo '<div class="d-flex flex-row justify-content-between mb-3"><div class="mr-2"> Commande n° ' . $biggestOrder->getIdOrder() . '</div><a class="btn-see-order" href="' . BASE_URL . 'article/orders' . '">see</a></div>';
                        } ?>
                    </div>
                </div>
                <div class="d-flex flex-column mt-4 mt-lg-0">
                    <h2>Website Consultation</h2>
                    <div id="toastPieConnection"> </div>
                </div>
                <div class="d-flex flex-column ">
                    <p class="statistic_titles">TOP 10 Users</p>
                    <div id="mostConnectedUsers" class="border p-3">
                        <?php foreach ($mostConnectedUsers as $mostConnectedUser) {
                            echo '<div class="d-flex flex-row justify-content-between mb-3"><div class="mr-2">' . $mostConnectedUser["name"] . '</div><a class="btn-see-user" href="' . BASE_URL . 'user/edit/' . $mostConnectedUser["id"] . '">see</a></div>';
                        } ?>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row flex-wrap justify-content-lg-between justify-content-center mt-4 mt-lg-3">
                <div class="d-flex flex-column col-12 col-lg-5">
                    <h2>Recipes</h2>
                    <div class="d-flex flex-row flex-wrap justify-content-lg-between justify-content-center">
                        <div>
                            <p class="statistic_titles">TOP 10 Chiefs</p>
                            <div id="topChief" class="border p-3">
                                <?php foreach ($topChiefs as $topChief) {
                                    echo '<div class="d-flex flex-row justify-content-between mb-3"><div class="mr-2">' . $topChief->getLastName() . " " . $topChief->getFirstName() . '</div><a class="btn-see-user" href="' . BASE_URL . 'user/edit/' . $topChief->getIdUser() . '">see</a></div>';
                                } ?>
                            </div>
                        </div>

                        <div class="mt-2 mt-lg-0">
                            <p class="statistic_titles">TOP 10 Recipes</p>
                            <div id="topRecipe" class="border p-3">
                                <?php foreach ($topRecipes as $recipe) {
                                    echo '<div class="d-flex flex-row justify-content-between mb-3"><a class="mr-2 btn-see-recipe" href="' . BASE_URL . 'recipe/edit/' . $recipe->getIdRecipe() . '">' . $recipe->getRecipeName() . '</a><div>by ' . $recipe->getChief()->getLastName() . " " . $recipe->getChief()->getFirstName() . '</div></div>';
                                } ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-column mt-4 mt-lg-0 mb-3">
                    <h2>Articles</h2>
                    <p>Articles for sales : <?php echo count($articles); ?></p>
                    <div id="toastArticles"> </div>
                    <p class="statistic_titles">Out of stock</p>
                    <table class="table-borderless table-striped" id="table" data-toggle="table" data-sortable="true">
                        <thead>
                            <th>Name</th>

                            <th>Quantity sold</th>

                            <th>Benefits</th>

                            <th>Action</th>

                        </thead>
                        <tbody id="allOutOfStockArticles">
                            <?php
                            foreach ($articleOutOfStock as $article) {
                                echo '<tr>';
                                echo '<td>' . $article->getProduct()->getProductName() . " (" . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " )" . '</td>';
                                echo '<td>' . $article->getQuantitySold() . '</td>';
                                echo '<td>' . $article->getBenefits() . '</td>';
                                echo '<td>';
                                echo '<a class="btn-see-articleOutOfStock" href="' . BASE_URL . 'article/edit/' . $article->getIdArticle() . '">see</br></a>';
                                echo '</td>';
                                echo '</tr>';
                            } ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

    <script>
        var screenwidth = window.screen.width;
        // ---------------------------- Orders -----------------------------//
        const el = document.getElementById('toastOrders');
        var totalPurchasedPerDay = <?php echo json_encode($totalPurchasedPerDay) ?>;
        var totalSoldPerDay = <?php echo json_encode($totalSoldPerDay) ?>;
      
        const data = {

            categories: [
                '0',
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9'
            ],

            series: [{
                name: 'Cost',
                data: totalPurchasedPerDay,
            }, {
                name: 'Sells',
                data: totalSoldPerDay,
            }],
        };

        const options = {
            chart: {
                title: '',
                width: 600,
                height: 300
            },
            legend: {
                visible: (screenwidth >600 ? true : false)
            },
            xAxis: {
                pointOnColumn: false,
                title: {
                    text: ''
                }
            },
            yAxis: {
                title: ''
            },
        };

        const chartLog = toastui.Chart.lineChart({
            el,
            data,
            options
        });


        // ---------------------------- Website Consultation -----------------------------//
        const el1 = document.getElementById('toastPieConnection');
        var connectionPerHour = <?php echo json_encode($connectionPerHour) ?>;
        const dataConnectionLogPerHour = {
            categories: ['Connection'],
            series: connectionPerHour
        }
        const optionsConnectionLog = {
            chart: {
                title: '',
                width: 500,
                height: 400
            },
            legend: {
                visible: false
            },
            series: {
                dataLabels: {
                    visible: true,
                    anchor: 'outer',
                    formatter: (value) => value,
                    pieSeriesName: {
                        visible: true,
                    },
                },
                radiusRange: {
                    inner: '60%',
                    outer: '100%',
                }
            }

        };
        const chartConection = toastui.Chart.pieChart({
            el: el1,
            data: dataConnectionLogPerHour,
            options: optionsConnectionLog
        });

        // ---------------------------- Articles -----------------------------//
        const el2 = document.getElementById('toastArticles');
        var articleSold = <?php echo json_encode($articleSold) ?>;
        var articleBought = <?php echo json_encode($articleBought) ?>;
        var articles = <?php echo json_encode($articles) ?>;
        var articleInStock = <?php echo json_encode($articleInStock) ?>;
        var clésDenses = Object.keys(articles);

        const dataArticle = {
            categories: clésDenses,
            series: [{
                    name: 'cost amount',
                    data: articleBought,
                },
                {
                    name: 'sold amount',
                    data: articleSold,
                }
            ],
        };
        const optionsArticle = {
            chart: {
                title: "",
                width: 600,
                height: 300
            },
            legend: {
                visible: (screenwidth >600 ? true : false)
            },
        };

        const chartArticle = toastui.Chart.columnChart({
            el: el2,
            data: dataArticle,
            options: optionsArticle
        });
    </script>

<?php } ?>