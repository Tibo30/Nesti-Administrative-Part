<?php
if (!isset($disconnect) || empty($disconnect)) {
    $disconnect = false;
}
?>

<div id="connectionPage">
     <!-- div notif disconnection -->
     <div id="disconnectSuccess" class="notifications" <?php if($disconnect==false){
         echo  "hidden";
     } ?>>
        <p>Successfully disconnected</p>
    </div>
    <div id="logoNesti" class="position-absolute">
        <img src="<?= BASE_URL . PATH_ICONS ?>Nesti-logo.png" alt="Nesti logo">
    </div>
    <div class="container h-100 d-flex" style="max-width:70%">
        <div class="container border my-auto bg-white" id="connectionForm">
            <div class="login-form d-flex justify-content-center">
                <form action="<?= BASE_URL . "connection" ?>" method="POST" id="formConnection">
                    <h2 class="text-center mb-5">Log in</h2>
                    <div class="form-group">
                        <label for="emailUsernameConnection">Email/Username</label>
                        <div class="d-flex align-items-center">
                            <i class="far fa-user mr-1"></i>
                            <input type="text" id="emailUsernameConnection" class="form-control" placeholder="Email/Username" required="required" name="emailUsername">
                        </div>
                        <span class="text-danger" id="errorEmailUsername"></span>
                    </div>
                    <div class="form-group">
                        <label for="passwordConnection">Password</label>
                        <div class="d-flex align-items-center ">
                            <i class="fas fa-lock mr-1"></i>
                            <input type="password" id="passwordConnection" class="form-control" placeholder="Password" required="required" name="password">
                        </div>
                        <span class="text-danger" id="errorPassword"></span>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-block">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

    // -------------------------------- Connect user --------------------------// 

    var connectionForm = document.querySelector("#formConnection"); // get the form used to connect the user
    // Event listener on the form
    connectionForm.addEventListener('submit', (function(e) {
        event.preventDefault(); // stop the default action of the form
        connectUser(this).then((response) => {
            if (response) {
                if (response.success) {
                    window.location = ROOT + "recipe";
                } else {
                    document.querySelector("#errorEmailUsername").innerHTML = response.errorMessages['emailUsername'];
                    document.querySelector("#errorPassword").innerHTML = response.errorMessages['password'];
                }
            }
        });
    }))

    /**
     * Ajax Request to connect the user
     * @param {form} obj
     * @returns mixed
     */
    async function connectUser(obj) {
        var myHeaders = new Headers();

        let formData = new FormData(obj);

        var myInit = {
            method: 'POST',
            headers: myHeaders,
            mode: 'cors',
            cache: 'default',
            body: formData
        };
        let response = await fetch(ROOT + 'connection', myInit);
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