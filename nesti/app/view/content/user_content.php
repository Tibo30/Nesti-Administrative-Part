<?php
if (!isset($users)) {
    $users=[];
    if (!empty($users)){
        foreach ($users as $user) {
            $user = new User();
        }
    }
}
if (!isset($logs)) {
    $logs =[];
    if (!empty($logs)){
        foreach ($logs as $log) {
            $log = new UserLog();
        }
    }
}

?>

<div class="container bg-white d-flex flex-column align-items-left" id="recipePage">
    <h2 class="mb-2 mt-2">Users</h2>
    <div class="d-flex flex-row justify-content-between">
        <nav class="navbar navbar-white bg-white pl-0">
            <form class="form-inline">
                <input class="form-control mr-sm-2" id="customSearchUser" type="search" placeholder="Search" aria-label="Search">
                <img id="searchUser" src="<?php echo BASE_URL ?>public/pictures/search-svg.svg" alt="">
            </form>
        </nav>
        <div>
            <a id="btnAddUser" href="user/add" class="btn mb-1 border align-self-end"> <img id="addUser" src="<?php echo BASE_URL ?>public/pictures/create-svg.svg" alt="svg plus">
                Add User</a>
        </div>

    </div>

    <table 
    class="table-borderless table-striped" 
    id="table" data-toggle="table" 
    data-sortable="true" 
    data-pagination="true"
     data-pagination-pre-text="Previous" 
     data-pagination-next-text="Next" 
     data-search="true" 
     data-search-align="left" 
     data-search-selector="#customSearchUser" 
     data-locale="eu-EU" 
     data-toolbar="#toolbar" 
     data-toolbar-align="left">
        <thead>
            <th>ID</th>

            <th>Name</th>

            <th>Role</th>

            <th>Last Connection</th>

            <th>State</th>

            <th>Actions</th>

        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . $user->getIdUser() . '</td>';
                echo '<td>' . $user->getLastname() . ' ' .  $user->getFirstname() . '</td>';
                echo '<td>' . implode(", ",$user->getRoles()). '</td>';
                echo '<td>'.   $user->getLog()->getConnectionDate().' </td>';
                echo '<td>' . $user->getState() . '</td>';
                echo '<td>';
                echo '<a href="' . BASE_URL . 'user/edit/' . $user->getIdUser() . '">Modify</br></a>';
                echo '<a href="' . BASE_URL . 'user/delete/' . $user->getIdUser() . '">Delete</a>';
                echo '</td>';
                echo '</tr>';
            } ?>
        </tbody>
        </tbody>
    </table>

</div>