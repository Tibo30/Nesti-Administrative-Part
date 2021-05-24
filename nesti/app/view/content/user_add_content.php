    <div class="container bg-white align-items-left position-relative" id="userAddPage">
        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>user"><u>Users</u>
            </a>
            <p> &nbsp > Create</p>
        </div>

        <!-- div notif user created -->
        <div id="userCreatedSuccess" class="notifications" hidden>
            <p>The user has been successfully created. You are going to be redirected to users page in 3 secondes </p>
        </div>

        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">User Creation</h2>


            <!-- Section Top -->
            <div class="d-flex flex-row px-5 px-md-0 justify-content-md-around justify-content-center">

                <!-- Article Input Informations Recipe-->

                <form method="POST" action="<?= BASE_URL ?>user/add" id="addUserForm" class="application">
                    <div class="row d-flex justify-content-between">
                        <div class="col-12 col-md-5">

                            <div class="row mb-2">
                                <label for="inputUserLastname">Lastname *</label>
                                <input type="text" class="form-control" id="inputUserLastname" name="userLastname" value="">
                            </div>
                            <span class="text-danger" id="errorUserLastname"></span>

                            <div class=" row mb-2">
                                <label for="inputUserFirstname">Firstname *</label>
                                <input type="text" class="form-control" id="inputUserFirstname" name="userFirstname" value="">
                            </div>
                            <span class="text-danger" id="errorUserFirstname"></span>

                            <div class="row mb-2">
                                <label for="inputUserEmail">Email *</label>
                                <input type="text" class="form-control" id="inputUserEmail" name="userEmail" value="">
                            </div>
                            <span class="text-danger" id="errorUserEmail"></span>

                            <div class="row mb-2">
                                <label for="inputUserUsername">Username *</label>
                                <input type="text" class="form-control" id="inputUserUsername" name="userUsername" value="">
                            </div>
                            <span class="text-danger" id="errorUserUsername"></span>

                            <div class="row mb-2">
                                <label for="inputUserPassword">Password *</label>
                                <input type="password" class="form-control" id="inputUserPassword" name="userPassword" value="">
                                <progress id="pwdStrength" value="0" max="100"></progress>
                            </div>
                            <span class="text-danger" id="errorUserPassword"></span>

                            <div id="passwordVerification">
                                <div class="font-weight-bold">Your password has to respect these rules : </div>
                                <div id='passwordConditions'>
                                    <div id='pwdLength'> • At least 12 characters</div>
                                    <div id='pwdLowCase'> • At least one lowercase</div>
                                    <div id='pwdUpperCase'> • At least one uppercase</div>
                                    <div id='pwdDigit'> • At least one number</div>
                                    <div id='pwdSpecial'> • At least a special character</div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-5">

                            <div class="row mb-2">
                                <label for="inputUserConfirmPassword">Confirm Password *</label>
                                <input type="password" class="form-control" id="inputUserConfirmPassword" name="userConfirmPassword" value="">
                            </div>
                            <span class="text-danger" id="errorUserConfirmPassword"></span>

                            <div class=" row mb-2">
                                <label for="inputUserAddress1">Address *</label>
                                <input type="text" class="form-control" id="inputUserAddress1" name="userAddress1" value="">
                            </div>
                            <span class="text-danger" id="errorUserAddress1"></span>

                            <div class="row mb-2">
                                <label for="inputUserAddress2">Additional address</label>
                                <input type="text" class="form-control" id="inputUserAddress2" name="userAddress2" value="">
                            </div>
                            <span class="text-danger" id="errorUserAddress2"></span>

                            <div class="row mb-2">
                                <label for="inputUserCity">City *</label>
                                <input type="text" class="form-control" id="inputUserCity" name="userCity" value="">
                            </div>
                            <span class="text-danger" id="errorUserCity"></span>

                            <div class="row mb-2">
                                <label for="inputUserPostcode">Postcode *</label>
                                <input type="text" class="form-control" id="inputUserPostcode" name="userPostCode" value="">
                            </div>
                            <span class="text-danger" id="errorUserPostcode"></span>

                            <div class="row justify-content-around">

                                <div class="d-flex flex-column">
                                    <div>
                                        <label for="inputUserRole">Role(s)</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="admin" name="userRoles[]" value="admin">
                                        <label for="admin"> Administrator</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="mod" name="userRoles[]" value="moderator">
                                        <label for="mod"> Moderator </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="chief" name="userRoles[]" value="chief">
                                        <label for="chief"> Chief </label>
                                    </div>
                                </div>

                                <div class="d-flex flex-column">
                                    <div>
                                        <label for="inputUserState">State</label>
                                    </div>
                                    <div>
                                        <select name="userState" id="userState">
                                            <option value="a">Active</option>
                                            <option value="b">Blocked</option>
                                            <option value="w">Waiting</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-around mt-3">
                        <button id="submitNewUser" class="btn" type="submit">Submit</button>
                        <button id="cancelNewUser" class="btn" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
        const ROOT = '<?= BASE_URL ?>';
    </script>