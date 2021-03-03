<?php
if (!isset($userAdd) || empty($userAdd)) {
    $userAdd = new User();
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
                        <input type="text" class="form-control p-0" id="inputUserLastname" name="userLastname" value="<?php echo !empty($userAdd->getLastname()) ? htmlspecialchars($userAdd->getLastname(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userLastname', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userLastname']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserFirstname">Firstname</label>
                        <input type="text" class="form-control p-0" id="inputUserFirstname" name="userFirstname" value="<?php echo !empty($userAdd->getFirstname()) ? htmlspecialchars($userAdd->getFirstname(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userFirstname', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userFirstname']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserUsername">Username</label>
                        <input type="text" class="form-control p-0" id="inputUserUsername" name="userUsername" value="<?php echo !empty($userAdd->getUsername()) ? htmlspecialchars($userAdd->getUsername(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userUsername', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userUsername']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserEmail">Email</label>
                        <input type="text" class="form-control p-0" id="inputUserEmail" name="userEmail" value="<?php echo !empty($userAdd->getEmail()) ? htmlspecialchars($userAdd->getEmail(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userEmail', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userEmail']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserPassword">Password</label>
                        <input type="text" class="form-control p-0" id="inputUserPassword" name="userPassword" value="<?php echo !empty($userAdd->getPassword()) ? htmlspecialchars($userAdd->getPassword(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userPassword', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userPassword']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex flex-column">
                    <div class="form-group">
                        <label for="inputUserState">State</label>
                        <input type="text" class="form-control p-0" id="inputUserState" name="userState" value="<?php echo !empty($userAdd->getState()) ? htmlspecialchars($userAdd->getState(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userState', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userState']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="inputUserAdress1">Adress1</label>
                        <input type="text" class="form-control p-0" id="inputUserAdress1" name="userAddress1" value="<?php echo !empty($userAdd->getAddress1()) ? htmlspecialchars($userAdd->getAddress1(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userAddress1', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userAddress1']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserAdress2">Adress2</label>
                        <input type="text" class="form-control p-0" id="inputUserAdress2" name="userAddress2" value="<?php echo !empty($userAdd->getAddress2()) ? htmlspecialchars($userAdd->getAddress2(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userAddress2', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userAddress2']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserPostcode">Postcode</label>
                        <input type="text" class="form-control p-0" id="inputUserPostcode" name="userPostcode" value="<?php echo !empty($userAdd->getPostCode()) ? htmlspecialchars($userAdd->getPostCode(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userPostcode', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userPostcode']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserCity">City</label>
                        <input type="text" class="form-control p-0" id="inputUserCity" name="userCity" value="<?php echo !empty($userAdd->getIdCity()) ? htmlspecialchars($userAdd->getIdCity(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userCity', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userCity']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="inputUserRoles">Roles</label>
                        <input type="text" class="form-control p-0" id="inputUserRoles" name="userRoles" value="<?php echo !empty($userAdd->getRoles()) ? htmlspecialchars($userAdd->getRoles(), ENT_QUOTES) : ''; ?>">
                        <?php if (array_key_exists('userRoles', $errorMessages)) : ?>
                            <span class="text-danger"><?php echo $errorMessages['userRoles']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="d-flex flex-row justify-content-center">
                <button id="submitNewUser" type="submit" class="btn mr-5">Submit</button>
                <button id="cancelNewUser" type="reset" class="btn">Cancel</button>
            </div>
        </form>

    </div>

</div>