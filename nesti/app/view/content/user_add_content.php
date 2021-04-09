<?php
if (!isset($userAdd) || empty($userAdd)) {
    $userAdd = new User();
}
if (!isset($errorMessages) || empty($errorMessages)) {
    $errorMessages = [];
}

?>

<?php if (array_search("moderator", $_SESSION["roles"]) !== false || array_search("admin", $_SESSION["roles"]) !== false) {

?>
    <div class="container bg-white align-items-left position-relative" id="userAddPage">
        <!-- div notif user created -->
        <div id="userCreatedSuccess" class="notifications" hidden>
            <p>The user has been successfully created </p>
        </div>
        <div class="d-flex flex-row underLink">
            <a href="<?= BASE_URL ?>user"><u>Users</u>
            </a>
            <p> &nbsp > Create</p>
        </div>

        <div class="d-flex flex-column">
            <h2 class="mb-2 mt-2">User Creation</h2>


            <!-- Section Top -->
            <div class="d-flex flex-row justify-content-around">

                <!-- Article Input Informations Recipe-->

                <form method="POST" action="<?= BASE_URL ?>user/add" id="addUserForm" class="application">
                    <div class="row d-flex justify-content-between">
                        <div class="col-5">

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

                            <br>

                        </div>

                        <div class="col-5">

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

                            <div class="row mb-2">

                                <div class="col-6">
                                    <label for="inputUserRole">Role(s)</label> <br>

                                    <input type="checkbox" id="admin" name="userRoles[]" value="admin">
                                    <label for="admin"> Administrator</label><br>

                                    <input type="checkbox" id="mod" name="userRoles[]" value="moderator">
                                    <label for="mod"> Moderator </label><br>

                                    <input type="checkbox" id="chief" name="userRoles[]" value="chief">
                                    <label for="chief"> Chief </label><br>

                                </div>

                                <div class="col-6">
                                    <label for="inputUserState">State</label> <br>
                                    <select name="userState" id="userState">
                                        <option value="a">Active</option>
                                        <option value="b">Blocked</option>
                                        <option value="w">Waiting</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-around">
                        <button id="submitNewUser" class="btn" type="submit">Submit</button>
                        <button id="cancelNewUser" class="btn" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php } else { ?>


    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } ?>

<script>
    const ROOT_ICONS = '<?= BASE_URL . PATH_ICONS ?>';
    const ROOT = '<?= BASE_URL ?>';

    // hide the notification after a click
    var notifs = document.querySelectorAll(".notifications");
    notifs.forEach(element =>
        element.addEventListener('click', (function(e) {
            element.hidden = true;
        }))
    )

    // -------------------------------- Add user --------------------------//  

    var formAddUser = document.querySelector("#addUserForm"); // get the form used to add the user
    // Event listener on the form
    formAddUser.addEventListener('submit', (function(e) {
        event.preventDefault(); // stop the default action of the form

        addUser(this).then((response) => {
            if (response) {
                if (response.success) {
                    document.querySelector("#inputUserLastname").value = response.userLastname;
                    document.querySelector("#inputUserFirstname").value = response.userFirstname;
                    document.querySelector("#inputUserEmail").value = response.userEmail;
                    document.querySelector("#inputUserUsername").value = response.userUsername;
                    document.querySelector("#inputUserPassword").value = response.userPassword;
                    document.querySelector("#inputUserConfirmPassword").value = response.userConfirmPassword;
                    document.querySelector("#inputUserAddress1").value = response.userAddress1;
                    document.querySelector("#inputUserAddress2").value = response.userAddress2;
                    document.querySelector("#inputUserCity").value = response.userCity;
                    document.querySelector("#inputUserPostcode").value = response.userPostcode;
                    if (response.userRoles.indexOf('admin') != -1) {
                        document.querySelector("#admin").checked = true;
                    }
                    if (response.userRoles.indexOf('moderator') != -1) {
                        document.querySelector("#mod").checked = true;
                    }
                    if (response.userRoles.indexOf('chief') != -1) {
                        document.querySelector("#chief").checked = true;
                    }
                    if (response.userState == "a") {
                        document.querySelector("#userState").options.selectedIndex = 0;
                    } else if (response.userState == "b") {
                        document.querySelector("#userState").options.selectedIndex = 1;
                    } else if (response.userState == "w") {
                        document.querySelector("#userState").options.selectedIndex = 2;
                    }

                    document.querySelector("#errorUserLastname").innerHTML = "";
                    document.querySelector("#errorUserFirstname").innerHTML = "";
                    document.querySelector("#errorUserEmail").innerHTML = "";
                    document.querySelector("#errorUserUsername").innerHTML = "";
                    document.querySelector("#errorUserPassword").innerHTML = "";
                    document.querySelector("#errorUserConfirmPassword").innerHTML = "";
                    document.querySelector("#errorUserAddress1").innerHTML = "";
                    document.querySelector("#errorUserAddress2").innerHTML = "";
                    document.querySelector("#errorUserCity").innerHTML = "";
                    document.querySelector("#errorUserPostcode").innerHTML = "";

                    document.querySelector("#userCreatedSuccess").hidden = false;

                } else {
                    document.querySelector("#errorUserLastname").innerHTML = response.errorMessages['userLastname'];
                    document.querySelector("#errorUserFirstname").innerHTML = response.errorMessages['userFirstname'];
                    document.querySelector("#errorUserEmail").innerHTML = response.errorMessages['userEmail'];
                    document.querySelector("#errorUserUsername").innerHTML = response.errorMessages['userUsername'];
                    document.querySelector("#errorUserPassword").innerHTML = response.errorMessages['userPassword'];
                    document.querySelector("#errorUserConfirmPassword").innerHTML = response.errorMessages['userConfirmPassword'];
                    document.querySelector("#errorUserAddress1").innerHTML = response.errorMessages['userAddress1'];
                    document.querySelector("#errorUserAddress2").innerHTML = response.errorMessages['userAddress2'];
                    document.querySelector("#errorUserCity").innerHTML = response.errorMessages['userCity'];
                    document.querySelector("#errorUserPostcode").innerHTML = response.errorMessages['userPostcode'];

                    console.log(response.errorMessages)

                }
            }
        });
    }))

    /**
     * Ajax Request to add a user to the database
     * @param {form} obj
     * @returns mixed
     */
    async function addUser(obj) {
        var myHeaders = new Headers();

        let formData = new FormData(obj);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'user/add', myInit);
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

    // -------------------------------- Handle password strength --------------------------//
    const pw = document.getElementById("inputUserPassword");

    pw.addEventListener('keyup', function() {

        if (pw.value == '') {
            document.getElementById("pwdStrength").value = 0;

        } else {
            document.getElementById("pwdStrength").value = passwordStrength(pw.value);
        }
    });

    // Checks the strength of the password
    function passwordStrength(pw) {

        changeColorConditions(pw);

        var n = 0;
        var strength = 0;
        if (/\d/.test(pw)) {
            n += 10;
        }
        if (/[a-z]/.test(pw)) {
            n += 26;
        }
        if (/[A-Z]/.test(pw)) {
            n += 26;
        }
        if (/\W/.test(pw)) {
            n += 28;
        }
        strength = Math.round(pw.length * Math.log(n) / Math.log(2));

        if (strength >= 100) {
            strength = 100;
        }
        console.log(strength)
        return strength;
    }

    // Changes the color of the conditions depending of the input password
    function changeColorConditions(pw) {

        if (/.{12,}/.test(pw) == true) {
            document.getElementById("pwdLength").style.color = 'green'
        } else(
            document.getElementById("pwdLength").style.color = 'red'
        )

        if (/[a-z]/.test(pw) == true) {
            document.getElementById("pwdLowCase").style.color = 'green'
        } else(
            document.getElementById("pwdLowCase").style.color = 'red'
        )

        if (/[A-Z]/.test(pw) == true) {
            document.getElementById("pwdUpperCase").style.color = 'green'
        } else(
            document.getElementById("pwdUpperCase").style.color = 'red'
        )

        if (/\d/.test(pw) == true) {
            document.getElementById("pwdDigit").style.color = 'green'
        } else(
            document.getElementById("pwdDigit").style.color = 'red'
        )

        if (/\W/.test(pw) == true) {
            document.getElementById("pwdSpecial").style.color = 'green'
        } else(
            document.getElementById("pwdSpecial").style.color = 'red'
        )
    }
</script>