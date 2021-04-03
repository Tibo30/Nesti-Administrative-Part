<?php
if (!isset($user) || empty($user)) {
    $user = new User();
}
?>

<div class="container bg-white align-items-left" id="userEditPage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>user"><u>Users</u>
        </a>
        <p> &nbsp > Edit</p>
    </div>
    <div class="d-flex flex-row justify-content-between">
        <div class="col-4">
            <div class="d-flex flex-column">
                <h2 class="mb-2 mt-2">User Edit</h2>
                <form method="POST" action="" class="application">

                    <div class="row mb-2">
                        <label for="inputUserEditLastname">Lastname *</label>
                        <input type="text" class="form-control" id="inputUserEditLastname" name="userLastname" value="<?= $user->getLastname() ?>">
                    </div>
                    <span class="text-danger" id="errorUserEditLastname"></span>

                    <div class=" row mb-2">
                        <label for="inputUserEditFirstname">Firstname *</label>
                        <input type="text" class="form-control" id="inputUserEditFirstname" name="userFirstname" value="<?= $user->getFirstname() ?>">
                    </div>
                    <span class="text-danger" id="errorUserEditFirstname"></span>

                    <div class=" row mb-2">
                        <label for="inputUserEditAddress1">Address *</label>
                        <input type="text" class="form-control" id="inputUserEditAddress1" name="userAddress1" value="<?= $user->getAddress1() ?>">
                    </div>
                    <span class="text-danger" id="errorUserEditAddress1"></span>

                    <div class="row mb-2">
                        <label for="inputUserEditAddress2">Additional address</label>
                        <input type="text" class="form-control" id="inputUserEditAddress2" name="userAddress2" value="<?= $user->getAddress2() ?>">
                    </div>
                    <span class="text-danger" id="errorUserEditAddress2"></span>

                    <div class="row mb-2">
                        <label for="inputUserEditCity">City *</label>
                        <input type="text" class="form-control" id="inputUserEditCity" name="userCity" value='<?= $user->getCity()->getCityName() ?>'>
                    </div>
                    <span class="text-danger" id="errorUserEditCity"></span>

                    <div class="row mb-2">
                        <label for="inputUserEditPostcode">Postcode *</label>
                        <input type="text" class="form-control" id="inputUserEditPostcode" name="userPostcode" value="<?= $user->getPostCode() ?>">
                    </div>
                    <span class="text-danger" id="errorUserEditPostcode"></span>

                    <div class="row">

                        <div class="col-6">
                            <label for="inputUserEditRole">Role(s) *</label> <br>
                            <input type="checkbox" id="admin" name="roles_user[]" value="admin" <?php foreach ($user->getRoles() as $role) {
                                                                                                    if ($role == 'admin') {
                                                                                                        echo 'checked';
                                                                                                    };
                                                                                                }; ?>>
                            <label for="admin"> Administrator </label><br>
                            <input type="checkbox" id="mod" name="roles_user[]" value="moderator" <?php foreach ($user->getRoles() as $role) {
                                                                                                        if ($role == 'moderator') {
                                                                                                            echo 'checked';
                                                                                                        };
                                                                                                    }; ?>>
                            <label for="mod"> Moderator </label><br>
                            <input type="checkbox" id="chief" name="roles_user[]" value="chief" <?php foreach ($user->getRoles() as $role) {
                                                                                                    if ($role == 'chief') {
                                                                                                        echo 'checked';
                                                                                                    };
                                                                                                }; ?>>
                            <label for="chief"> Chief </label><br>
                        </div>

                        <div class="col-6">
                            <label for="inputUserEditState">State *</label> <br>
                            <select name="userState" id="userEditState">
                                <option value="a" <?php if ($user->getState() == 'a') {
                                                        echo 'selected';
                                                    }; ?>>Active</option>
                                <option value="b" <?php if ($user->getState() == 'b') {
                                                        echo 'selected';
                                                    }; ?>>Blocked</option>
                                <option value="w" <?php if ($user->getState() == 'w') {
                                                        echo 'selected';
                                                    }; ?>>Waiting</option>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="row d-flex justify-content-around">
                        <button id="submitEditUser" class="btn" type="submit">Submit</button>
                        <button id="cancelEditUser" class="btn" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-6 p-0">
            <div class="d-flex flex-column justify-content-center align-items-start mb-2">


                <h2>Informations</h2>

                <div class="list border w-100">

                    <p> Creation Date : <?= $user->getCreationDate() ?> <br>
                        Last connection : <?= $user->getLog()->getConnectionDate() ?></p>

                    <?php $userRoles = $user->getRoles() ?>
                    <?php
                    if (array_search('chief', $userRoles) !== false) { ?>

                        <p>
                        <h5> Chief </h5>
                        Number of recipes : <?= count($user->getRecipes()) ?> <br>
                        Last recipe : <?= $user->getLastRecipe()->getRecipeName() ?> </p>

                    <?php
                    }
                    if (array_search('user', $userRoles) !== false) { ?>
                        <p>
                        <h5> User </h5>
                        Number of orders : <?= count($user->getOrders()) ?><br>
                        Total amount of orders : <?= $user->getTotalAmountOrders() ?> €<br>
                        Last order : <?= $user->getLastOrder()->getAmount() ?> €</p>

                    <?php
                    }
                    if (array_search('admin', $userRoles) !== false) { ?>
                        <p>
                        <h5> Administrator </h5>
                        Number of import : <?= count($user->getImports()) ?> <br>
                        Last import : <?= $user->getLastImport()->getImportDate() ?> </p>


                    <?php
                    }
                    if (array_search('moderator', $userRoles) !== false) { ?>

                        <p>
                        <h5> Moderator </h5>
                        Number of approved comments : <?= $user->getCommentsNumber()["approved"] ?> <br>
                        Number of blocked comments : <?= $user->getCommentsNumber()["blocked"] ?> </p>

                    <?php
                    }

                    ?>
                </div>
            </div>
            <form method="POST" action="" class="">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-lg btn-info w-100" data-bs-toggle="modal" data-bs-target="#resetPassword">
                        Reset Password
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="resetPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Réinitialisation mot de passe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Vous êtes sur le point de réinitialiser le mot de passe de l'utilisateur.
                                Cette action est définitive et irréversible.
                                <br><br>
                                Êtes-vous sûr de vouloir réaliser cette action ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
                                <button type="submit" class="btn btn-success">Oui !</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>
    <br>
    <br>

    <div class="d-flex flex-column">
        <div class="col">
            <h1>His orders</h1>
            <h5>Consultation of his orders</h5>
        </div>
        <div class="d-flex flex-row justify-content-around">
            <div class="col-6">
                <br>
                <div class="wrapper-articles-table justify-content-between">
                    <div>
                        <div class="d-flex flex-row justify-content-between">
                            <nav class="navbar navbar-white bg-white pl-0">
                                <form class="form-inline">
                                    <input class="form-control mr-sm-2" id="customSearchOrderUser" type="search" placeholder="Search" aria-label="Search">
                                    <img id="searchOrderUser" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                                </form>
                            </nav>

                        </div>
                        <table class="table-borderless table-striped" rowEvents="" id="allOrdersUserTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchOrderUser" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
                            <thead>
                                <th>ID</th>

                                <th>User</th>

                                <th>Amount</th>

                                <th>Date</th>

                                <th>State</th>

                            </thead>
                            <tbody id="allOrdersTbody">
                                <?php
                                $orders = $user->getOrders();
                                foreach ($orders as $order) {
                                    echo '<tr class="orders" data-id="' . $order->getIdOrder() . '">';
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
                </div>

            </div>
            <div class="col-4 mb-3">
                <div class="d-flex justify-content-between px-3 align-items-end">
                    <h2>Details</h2>
                    <h4 id="idOrderUser" className="mr-5">N°:</h4>
                </div>
                <div id="listOrderLinesUser" class="d-flex flex-column justify-content-start w-100 p-2 bg-white border">
                </div>
            </div>

        </div>
    </div>
    <br>

    <div class="d-flex flex-column">
        <h1>His comments</h1>
        <h5>Moderation of his comments</h5>
        <br>
        <div class="d-flex flex-row">
            <div class="col-12">
                <div class="d-flex flex-row justify-content-between">
                    <nav class="navbar navbar-white bg-white pl-0">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" id="customSearchCommentUser" type="search" placeholder="Search" aria-label="Search">
                            <img id="searchCommentUser" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                        </form>
                    </nav>

                </div>
                <table class="table-borderless table-striped" rowEvents="" id="allCommentsUserTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchCommentUser" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
                    <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Recipe</th>
                        <th>Content</th>
                        <th>Date</th>
                        <th>State</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($user->getComments() as $comment) {
                        ?>
                            <tr>
                                <th>
                                    <?= $comment->getIdComment() ?>
                                </th>
                                <td>
                                    <?= $comment->getCommentTitle() ?>
                                </td>
                                <td>
                                    <?= $comment->getRecipe()->getRecipeName() ?>
                                </td>
                                <td>
                                    <?= $comment->getCommentContent() ?>
                                </td>
                                <td>
                                    <?= $comment->getCreationDate() ?>
                                </td>
                                <td>
                                    <?= $comment->getDisplayState(); ?>
                                </td>

                                <td>
                                    <form method="POST" action="<?= BASE_URL . "users/edition/" . $id . "/commentapproved" ?>" class="form-table mb-2 rounded bg-success">

                                        <button type="button" class="btn bt-tbl">
                                            Approuver
                                        </button>
                                    </form>


                                    <form method="POST" action="<?= BASE_URL . "users/edition/" . $id . "/commentdisapproved" ?>" class="form-table rounded bg-danger">

                                        <button type="button" class="btn bt-tbl">
                                            Bloquer
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>

                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>

</div>

<script>
    const ROOT = '<?= BASE_URL ?>';
    const myTable = document.querySelector("#allOrdersUserTable"); // get the table
    console.log(myTable);
    myTable.addEventListener('click', function() { // add event listener
        const orderId = event.target.parentNode.getAttribute('data-id'); // get the id of the parent node of the event target (td->tr)
        getOrderLines(orderId).then((response) => {
            if (response) {
                const divList = document.querySelector("#listOrderLinesUser")
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
                document.querySelector("#idOrderUser").innerHTML = "N°: " + orderId;

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
        let response = await fetch(ROOT + 'user/userorder', myInit);
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