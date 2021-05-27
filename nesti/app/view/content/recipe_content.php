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
<div class="container bg-white d-flex flex-column align-items-left position-relative" id="allRecipePage">
    <h2 class="mb-2 mt-3">Recettes</h2>
    <!-- div notif recipe delete -->
    <div id="recipeDeletedSuccess" class="notifications" hidden>
        <p>The recipe has been deleted (blocked)</p>
    </div>
    <div class="d-flex flex-row justify-content-xl-between justify-content-center flex-wrap ">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchRecipe" type="search" placeholder="Search" aria-label="Search">
                <img id="searchRecipe" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
            </form>
        </nav>
        <div class="pt-2">
            <a id="btnAddRecipe" href="recipe/add" class="btn mb-1 border align-self-end"> <img id="svgAddRecipe" src="<?php echo BASE_URL . PATH_ICONS ?>create-svg.svg" alt="svg plus">
                Add Recipe</a>
        </div>

    </div>

    <table class="table-borderless table-striped" id="allRecipesTable" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchRecipe" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
        <thead>
            <tr>
                <th>ID</th>

                <th>Name</th>

                <th>Difficulty</th>

                <th>For</th>

                <th>Time</th>

                <th>Chief</th>

                <th>State</th>

                <th>Actions</th>
            </tr>
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
                echo '<a class="btn-modify-recipe" href="' . BASE_URL . 'recipe/edit/' . $recipe->getIdRecipe() . ' " data-id=' . $recipe->getIdRecipe() . '>Modify<br></a>';
                echo '<a class="btn-delete-recipe" data-id=' . $recipe->getIdRecipe() . ' data-toggle="modal" data-target="#modalDeleteRecipe' . $recipe->getIdRecipe() . '">Delete</a>';
                echo '  <div class="modal fade" id="modalDeleteRecipe' . $recipe->getIdRecipe() . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle' . $recipe->getIdRecipe() . '" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle' . $recipe->getIdRecipe() . '">Do you really want to delete this recipe ?</h5>
                                <button type="button" class="close" id="closeModalDelete' . $recipe->getIdRecipe() . '" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- <div class="modal-body">
                                                                ...
                                                            </div> -->
                            <div class="modal-footer">
                                <button type="button" class="btn confirm-delete-recipe" data-id="' . $recipe->getIdRecipe() . '" onclick="allRecipesDelete()">Confirm</button>
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
</script>