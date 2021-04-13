<?php
if (!isset($recipes) || empty($recipes)) {
    $recipes = [];
    if (!empty($recipes)) {
        foreach ($recipes as $recipe) {
            $recipe = new Recipe();
        }
    }
}

?>
<?php
if (array_search("chief", $_SESSION["roles"]) !== false || array_search("admin", $_SESSION["roles"]) !== false) {

?>
    <div class="container bg-white d-flex flex-column align-items-left position-relative" id="allRecipePage">
        <!-- div notif recipe delete -->
        <div id="recipeDeletedSuccess" class="notifications" hidden>
            <p>The recipe has been deleted (blocked)</p>
        </div>
        <h2 class="mb-2 mt-2">Recettes</h2>
        <div class="d-flex flex-row justify-content-xl-between justify-content-center flex-wrap ">
            <nav class="navbar navbar-white bg-white pl-0">
                <form class="form-inline">
                    <input class="form-control mr-sm-2" id="customSearchRecipe" type="search" placeholder="Search" aria-label="Search">
                    <img id="searchRecipe" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                </form>
            </nav>
            <div>
                <a id="btnAddRecipe" href="recipe/add" class="btn mb-1 border align-self-end"> <img id="svgAddRecipe" src="<?php echo BASE_URL . PATH_ICONS ?>create-svg.svg" alt="svg plus">
                    Add Recipe</a>
            </div>

        </div>

        <table class="table-borderless table-striped" id="allRecipesTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchRecipe" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
            <thead>
                <th>ID</th>

                <th>Name</th>

                <th>Difficulty</th>

                <th>For</th>

                <th>Time</th>

                <th>Chief</th>

                <th>State</th>

                <th>Actions</th>
            </thead>
            <tbody id="allRecipesTbody">
                <?php foreach ($recipes as $recipe) {
                    echo '<tr>';
                    echo '<td>' . $recipe->getIdRecipe() . '</td>';
                    echo '<td>' . $recipe->getRecipeName() . '</td>';
                    echo '<td>' . $recipe->getDifficulty() . '</td>';
                    echo '<td>' . $recipe->getNumberOfPeople() . '</td>';
                    echo '<td>' . $recipe->getDisplayTime() . '</td>';
                    echo '<td>' . $recipe->getChief()->getLastName() . '</td>';
                    echo '<td>' . $recipe->getDisplayState() . '</td>';
                    echo '<td>';
                    echo '<a class="btn-modify-recipe" href="' . BASE_URL . 'recipe/edit/' . $recipe->getIdRecipe() . ' "data-id=' . $recipe->getIdRecipe() . '>Modify</br></a>';
                    echo '<a class="btn-delete-recipe" data-id=' . $recipe->getIdRecipe() . ' data-toggle="modal" data-target="#modalDeleteRecipe' . $recipe->getIdRecipe() . '">Delete</a>';
                    echo '  <div class="modal fade" id="modalDeleteRecipe' . $recipe->getIdRecipe() . '" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete this recipe ?</h5>
                                <button type="button" class="close" id="closeModalDelete' . $recipe->getIdRecipe() . '" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- <div class="modal-body">
                                                                ...
                                                            </div> -->
                            <div class="modal-footer">
                                <button id="confirm-delete-recipe" type="button" class="btn" data-id="' . $recipe->getIdRecipe() . '" onclick="allRecipesDelete()">Confirm</button>
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

        // hide the notification after a click
        var notifs = document.querySelectorAll(".notifications");
        notifs.forEach(element =>
            element.addEventListener('click', (function(e) {
                element.hidden = true;
            }))
        )

        function allRecipesDelete() {
            let idRecipe = event.target.getAttribute('data-id');
            const td = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.previousElementSibling; // get td of state for this recipe
            deleteRecipe(idRecipe).then((response) => {
                if (response) {
                    if (response.success) {
                        td.innerHTML = response.state;
                        document.querySelector("#closeModalDelete" + idRecipe).click();
                        document.querySelector("#recipeDeletedSuccess").hidden = false;
                    }
                }
            })
        }


        /**
         * Ajax Request to delete the Recipe (change the status to blocked)
         * @param int idRecipe
         * @returns mixed
         */
        async function deleteRecipe(idRecipe) {

            var myHeaders = new Headers();

            let formData = new FormData();
            formData.append('idRecipe', idRecipe);
            var myInit = {
                method: 'POST',
                headers: myHeaders,
                mode: 'cors',
                cache: 'default',
                body: formData
            };

            // Use the fetch API to access the database (the method is called in the ArticleController)
            let response = await fetch(ROOT + 'recipe/delete', myInit);
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

<?php } else { ?>


    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } ?>