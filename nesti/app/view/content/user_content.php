<?php
if (!isset($users)) {
    $users = [];
    if (!empty($users)) {
        foreach ($users as $user) {
            $user = new User();
        }
    }
}

?>

<?php
if (array_search("moderator", $_SESSION["roles"]) !== false || array_search("admin", $_SESSION["roles"]) !== false) {
?>
    <div class="container bg-white d-flex flex-column align-items-left position-relative" id="allUserPage">
        <!-- div notif user delete -->
        <div id="userDeletedSuccess" class="notifications" hidden>
            <p>The user has been deleted (blocked)</p>
        </div>
        <h2 class="mb-2 mt-2">Users</h2>
        <div class="d-flex flex-row justify-content-xl-between justify-content-center flex-wrap">
            <nav class="navbar navbar-white bg-white pl-0">
                <form class="form-inline">
                    <input class="form-control mr-sm-2" id="customSearchUser" type="search" placeholder="Search" aria-label="Search">
                    <img id="searchUser" src="<?php echo BASE_URL . PATH_ICONS ?>search-svg.svg" alt="">
                </form>
            </nav>
            <div>
                <a id="btnAddUser" href="user/add" class="btn mb-1 border align-self-end"> <img id="svgAddUser" src="<?php echo BASE_URL . PATH_ICONS ?>create-svg.svg" alt="svg plus">
                    Add User</a>
            </div>

        </div>

        <table class="table-borderless table-striped" id="table" data-toggle="table" data-sortable="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-search="true" data-search-align="left" data-search-selector="#customSearchUser" data-locale="eu-EU" data-toolbar="#toolbar" data-toolbar-align="left">
            <thead>
                <th>ID</th>

                <th>Username</th>

                <th>Name</th>

                <th>Role</th>

                <th>Last Connection</th>

                <th>State</th>

                <th>Actions</th>

            </thead>
            <tbody id="allUsersTbody">
                <?php
                foreach ($users as $user) {
                    echo '<tr>';
                    echo '<td>' . $user->getIdUser() . '</td>';
                    echo '<td>' . $user->getUsername() . '</td>';
                    echo '<td>' . $user->getLastname() . ' ' .  $user->getFirstname() . '</td>';
                    echo '<td>' . implode(" ", $user->getDisplayRoles()) . '</td>';
                    echo '<td>' .   $user->getLog()->getDisplayDate() . ' </td>';
                    echo '<td>' . $user->getDisplayState() . '</td>';
                    echo '<td>';
                    echo '<a class="btn-modify-user" href="' . BASE_URL . 'user/edit/' . $user->getIdUser() . ' "data-id=' . $user->getIdUser() . '>Modify</br></a>';
                    echo '<a class="btn-delete-user" data-id=' . $user->getIdUser() . ' data-toggle="modal" data-target="#modalDeleteUser' . $user->getIdUser() . '">Delete</a>';
                    echo '  <div class="modal fade" id="modalDeleteUser' . $user->getIdUser() . '" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete this user ?</h5>
                                <button type="button" class="close" id="closeModalDelete' . $user->getIdUser() . '" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- <div class="modal-body">
                                                                ...
                                                            </div> -->
                            <div class="modal-footer">
                                <button id="confirm-delete-user" type="button" class="btn" data-id="' . $user->getIdUser() . '" onclick="allUserDelete()">Confirm</button>
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

        function allUserDelete() {
            let idUser = event.target.getAttribute('data-id');
            const td = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.previousElementSibling; // get td of state for this user
            deleteUser(idUser).then((response) => {
                if (response) {
                    if (response.success) {
                        td.innerHTML = response.state;
                        document.querySelector("#closeModalDelete" + idUser).click();
                        document.querySelector("#userDeletedSuccess").hidden = false;
                    }
                }
            })
        }


        /**
         * Ajax Request to delete the User (change the status to blocked)
         * @param int idUser
         * @returns mixed
         */
        async function deleteUser(idUser) {

            var myHeaders = new Headers();

            let formData = new FormData();
            formData.append('idUser', idUser);
            var myInit = {
                method: 'POST',
                headers: myHeaders,
                mode: 'cors',
                cache: 'default',
                body: formData
            };

            // Use the fetch API to access the database (the method is called in the UserController)
            let response = await fetch(ROOT + 'user/delete', myInit);
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
<?php
} ?>