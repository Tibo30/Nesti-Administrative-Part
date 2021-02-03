<div id="connectionPage">
    <div class="container h-100 d-flex" style="max-width:70%">
        <div class="container border my-auto bg-white" id="connectionForm">
            <div class="login-form">
                <form action="/examples/actions/confirmation.php" method="POST">
                    <h2 class="text-center mb-5">Log in</h2>
                    <div class="form-group">
                        <label for="usernameConnection">Username</label>
                        <input type="text" id="usernameConnection" class="form-control" placeholder="Username" required="required">
                    </div>
                    <div class="form-group">
                        <label for="passwordConnection">Password</label>
                        <input type="password" id="passwordConnection" class="form-control" placeholder="Password" required="required">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Log in</button>
                    </div>
            </div>
            <?php
            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Incorrect Username or Password</p>";
            }
            ?>
        </div>
    </div>
</div>