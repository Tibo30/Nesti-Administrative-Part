<?php
if (!isset($recipeAdd) || empty($recipeAdd)) {
    $recipeAdd = new Recipe();
}
if (!isset($errorMessages) || empty($errorMessages)) {
    $errorMessages = [];
}

?>
<div class="container bg-white align-items-left" id="userPage">
    <div class="d-flex flex-row underLink">
        <a href="<?= BASE_URL ?>user"><u>Users</u>
        </a>
        <p> &nbsp > Create</p>
    </div>

    <div class="d-flex flex-column">
        <h2 class="mb-2 mt-2">User Creation</h2>
        <form method="post" style="width : 100%;">
            <div class="d-flex flex-row justify-content-around">
                <div class="d-flex flex-column">
                    <div class="form-group">
                        <label for="inputUserLastname">Lastname</label>
                        <input type="text" class="form-control p-0" id="inputUserLastname" name="userLastname" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserFirstname">Firstname</label>
                        <input type="text" class="form-control p-0" id="inputUserFirstname" name="userFirstname" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserUsername">Username</label>
                        <input type="text" class="form-control p-0" id="inputUserUsername" name="userUsername" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserEmail">Email</label>
                        <input type="text" class="form-control p-0" id="inputUserEmail" name="userEmail" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserPassword">Password</label>
                        <input type="text" class="form-control p-0" id="inputUserPassword" name="userPassword" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex flex-column">
                    <div class="form-group">
                        <label for="inputUserState">State</label>
                        <input type="text" class="form-control p-0" id="inputUserState" name="userState" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserAdress1">Adress1</label>
                        <input type="text" class="form-control p-0" id="inputUserAdress1" name="userAdress1" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserAdress2">Adress2</label>
                        <input type="text" class="form-control p-0" id="inputUserAdress2" name="userAdress2" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserPostcode">Postcode</label>
                        <input type="text" class="form-control p-0" id="inputUserPostcode" name="userPostcode" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserCity">City</label>
                        <input type="text" class="form-control p-0" id="inputUserCity" name="userCity" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserRoles">Roles</label>
                        <input type="text" class="form-control p-0" id="inputUserRoles" name="userRoles" value="<?php echo !empty($recipeAdd->getRecipeName()) ? htmlspecialchars($recipeAdd->getRecipeName(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('recipeName', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['recipeName']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="d-flex flex-row justify-content-center">
                <button id="submitNewRecipe" type="submit" class="btn mr-5">Submit</button>
                <button id="cancelNewRecipe" type="reset" class="btn">Cancel</button>
            </div>
        </form>

    </div>

</div>