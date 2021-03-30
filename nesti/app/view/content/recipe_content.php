<?php
if (!isset($recipes)||empty($recipes)) {
    $recipes=[];
    if (!empty($recipes)){
        foreach ($recipes as $recipe) {
            $recipe = new Recipe();
        }
    }
}

?>

<div class="container bg-white d-flex flex-column align-items-left" id="allRecipePage">
<h2 class="mb-2 mt-2">Recettes</h2>
    <div class="d-flex flex-row justify-content-between">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchRecipe" type="search" placeholder="Search" aria-label="Search">
                <img id="searchRecipe" src="<?php echo BASE_URL.PATH_ICONS ?>search-svg.svg" alt="">
            </form>
        </nav>
        <div>
        <a id="btnAddRecipe" href="recipe/add" class="btn mb-1 border align-self-end"> <img id="svgAddRecipe" src="<?php echo BASE_URL.PATH_ICONS ?>create-svg.svg" alt="svg plus">
            Add Recipe</a>
        </div>
        
    </div>

    <table class="table-borderless table-striped" 
    id="allRecipesTable" 
    data-toggle="table" 
    data-sortable="true" 
    data-pagination="true" 
    data-pagination-pre-text="Previous" 
    data-pagination-next-text="Next" 
    data-search="true" 
    data-search-align="left" 
    data-search-selector="#customSearchRecipe" 
    data-locale="eu-EU" 
    data-toolbar="#toolbar" 
    data-toolbar-align="left">
        <thead>
            <th>ID</th>

            <th>Name</th>

            <th>Difficulty</th>

            <th>For</th>

            <th>Time</th>

            <th>Chief</th>

            <th>Actions</th>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe) {
                echo '<tr>';
                echo '<td>' . $recipe->getIdRecipe() . '</td>';
                echo '<td>' . $recipe->getRecipeName() . '</td>';
                echo '<td>' . $recipe->getDifficulty() . '</td>';
                echo '<td>' . $recipe->getNumberOfPeople() . '</td>';
                echo '<td>' . $recipe->getTime() . ' min </td>';
                echo '<td>' . $recipe->getChief()->getLastName() . '</td>';
                echo '<td>';
                echo '<a class="btn-modify-recipe" href="' . BASE_URL . 'recipe/edit/' . $recipe->getIdRecipe() . ' "data-id='.$recipe->getIdRecipe().'>Modify</br></a>';
                echo '<a class="btn-modify-recipe" href="' . BASE_URL . 'recipe/delete/' . $recipe->getIdRecipe() . ' "data-id='.$recipe->getIdRecipe().'>Delete</a>';
                echo '</td>';
                echo '</tr>';
            } ?>
        </tbody>
    </table>

</div>