<?php
if (!isset($user)||empty($user)) {
    $user = new User();
}
?>

<div class="container bg-white align-items-left" id="recipePage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>user"><u>Users</u>
        </a>
        <p> &nbsp > Edit</p>
    </div>
    <div class="d-flex flex-row justify-content-around">
        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">User Edit</h2>
            <form>
                <div class="form-group">
                    <label for="inputLastName">Lastname</label>
                    <input type="text" class="form-control p-0" id="inputLastName" value="<?= $user->getLastname() ?>">
                </div>
         
                <div class="form-group">
                    <label for="inputFirstName">Firstname</label>
                    <input type="text" class="form-control p-0" id="inputFirstName" value="<?= $user->getFirstname() ?>">
                </div>
                <div class="form-group">
                    <label for="inputRole">Role</label>
                    <input type="text" class="form-control p-0" id="inputRole" value="<?= implode(", ",$user->getRoles()) ?>">
                </div>
                <div class="form-group">
                    <label for="inputState">State</label>
                    <input type="text" class="form-control p-0" id="inputState" value="<?= $user->getState() ?>">
                </div>               
                <div class="d-flex flex-row">
                    <button id="submitEditRecipe" type="submit" class="btn mr-5">Submit</button>
                    <button id="cancelEditRecipe" type="reset" class="btn">Cancel</button>
                </div>

            </form>
        </div>
        <div>
        <div id="pictureEdit" class="bg-light border mb-2"></div>
            <label class="form-label" for="customFile">Download a new picture</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="InputFile">
                <label class="custom-file-label" for="InputFile" data-browse="Browse"></label>
            </div>

        </div>
    </div>
</div>