<div id="connectionPage">
    <div id="logoNesti" class="position-absolute">
        <img src="<?= BASE_URL.PATH_ICONS ?>Nesti-logo.png" alt="Nesti logo">
    </div>
    <div class="container h-100 d-flex" style="max-width:70%">
        <div class="container border my-auto bg-white" id="connectionForm">
            <div class="login-form d-flex justify-content-center">
                <form action="" method="POST">
                    <h2 class="text-center mb-5">Log in</h2>
                    <div class="form-group">
                        <label for="emailConnection">Email</label>
                        <div class="d-flex align-items-center">
                        <i class="far fa-user mr-1"></i>
                        <input type="email" id="emailConnection" class="form-control" placeholder="Email" required="required" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passwordConnection">Password</label>
                        <div class="d-flex align-items-center ">
                        <i class="fas fa-lock mr-1"></i>
                        <input type="password" id="passwordConnection" class="form-control" placeholder="Password" required="required" name="password">
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-block">Log in</button>
                    </div>
            </div>
            <?php
            // if (isset($_GET['erreur'])) {
            //     $err = $_GET['erreur'];
            //     if ($err == 1 || $err == 2)
            //         echo "<p style='color:red'>Incorrect Username or Password</p>";
            // }
            ?>
        </div>
    </div>
</div>