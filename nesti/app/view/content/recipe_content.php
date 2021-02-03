<div class="container bg-light border d-flex flex-column align-items-left" id="recipePage">
    <h2 class="mb-5 mt-5">Recettes</h2>
    <nav class="navbar navbar-light bg-light">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-1 my-sm-0" type="submit">Search</button>
        </form>        
    </nav>
    <a href="index.php? loc=add" class="btn mb-1 border align-self-end">+ Add Recipe</a>
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
            <!-- <?php

                    foreach ($query->getAll() as $row) {
                        require_once('./entities/user.php');
                        $user = new User($row);
                        echo '<tr>';
                        echo '<td>' . $user->getID() . '</td>';
                        echo '<td>' . $user->getFirstname() . '</td>';
                        echo '<td>' . $user->getLastname() . '</td>';
                        echo '<td>' . $user->getUsername() . '</td>';
                        echo '<td>' . $user->getEmail() . '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-primary" href="index.php?loc=read&id=' . $user->getID() . '">Read</a>';
                        echo '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-success" href="index.php?loc=update&id=' . $user->getID() . '">Update</a>';
                        echo '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-danger" href="index.php?loc=delete&id=' . $user->getID() . ' ">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?> -->
        </tbody>

    </table>
</div>