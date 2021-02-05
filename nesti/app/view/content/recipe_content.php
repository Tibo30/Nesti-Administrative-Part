<?php 

?>

<div class="container bg-light border d-flex flex-column align-items-left" id="recipePage">
    <h2 class="mb-5 mt-5">Recettes</h2>
    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <img src="<?php BASE_URL ?>public/pictures/search-svg.svg" alt="">
            <button class="btn btn-outline-success my-1 my-sm-0" type="submit">Search</button>
        </form>        
    </nav>
    <h1>Recipes</h1>
    <a href="recipe/add" class="btn mb-1 border align-self-end"> <img src="<?php BASE_URL ?>public/pictures/create-svg.svg" alt="svg plus">
    Add Recipe</a>
    <table class="table table-hover text-center">
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
            echo '<td>' . $recipe->getTime() . '</td>';
            echo '<td>' . $recipe->getChiefName() . '</td>';
            echo '<td>';
            echo '<a href="'.BASE_URL.'recipe/edit/' . $recipe->getIdRecipe() . '">Modify</br></a>';
            echo '<a href="'.BASE_URL.'recipe/delete/' . $recipe->getIdRecipe() . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }?>
        </tbody>

    </table>
</div>