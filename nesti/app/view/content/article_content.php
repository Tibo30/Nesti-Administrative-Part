<!-- <h1>Articles</h1> -->
<!-- <?php

foreach($articles as $article): ?>
<h2><?= $article->getIdProduct() ?></h2>
<time><?= $article->getCreationDate() ?> </time>
<?php endforeach; ?> -->

<div class="container bg-light border d-flex flex-column align-items-left" id="recipePage">
    <h2 class="mb-5 mt-5">Article</h2>
    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-1 my-sm-0" type="submit">Search</button>
        </form>        
    </nav>
    <h1>Article</h1>
    <a href="recipe/add" class="btn mb-1 border align-self-end">+ Add Article</a>
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

        </tbody>

    </table>
</div>