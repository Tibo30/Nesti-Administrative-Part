<?php
if (!isset($disconnect) || empty($disconnect)) {
    $disconnect = false;
}
?>

<div id="connectionPage">
    <!-- div notif disconnection -->
    <div id="disconnectSuccess" class="notifications" <?php if ($disconnect == false) {
                                                            echo  "hidden";
                                                        } ?>>
        <p>Successfully disconnected</p>
    </div>
    <!-- div notif account not active -->
    <div id="accountNotActive" class="notifications" hidden>
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
</script>