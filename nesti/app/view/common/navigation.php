<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Navigation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-around" id="navbarResponsive">
      <ul class="navbar-nav">
        <li class="nav-item <?= ($url == 'recipe') ? 'active' : ''; ?> px-lg-4">
          <a class="nav-link" href="<?= BASE_URL ?>recipe">
            <i class="fas fa-clipboard-list mr-2"></i>
            Recipes</a>
        </li>
        <li class="nav-item <?= ($url == 'article') ? 'active' : ''; ?> px-lg-4">
          <a class="nav-link" href="<?= BASE_URL ?>article">
            <i class="fas fa-utensils mr-2"></i>
            Articles</a>
        </li>
        <li class="nav-item <?= ($url == 'user') ? 'active' : ''; ?> px-lg-4">
          <a class="nav-link" href="<?= BASE_URL ?>user">
            <i class="fas fa-user mr-2"></i>
            Users</a>
        </li>
        <li class="nav-item <?= ($url == 'statistic') ? 'active' : ''; ?> px-lg-4">
          <a class="nav-link" href="<?= BASE_URL ?>statistic">
            <i class="fas fa-chart-bar mr-2"></i>
            Statistics
          </a>
        </li>
        </ul>
        <ul class="navbar-nav">
        <div class="d-flex flex-row">
          <li class="nav-item whiteNav px-lg-4">
            <a class="nav-link" href="">
              <i class="fas fa-user mr-2"></i>
              <?php echo $_SESSION["lastname"] . " " . $_SESSION["firstname"] ?>
            </a>
          </li>
          <li class="nav-item whiteNav px-lg-4">
            <a class="nav-link" href="<?= BASE_URL ?>logOut">
              <i class="fas fa-sign-out-alt mr-2"></i>
              Log Out</a>
          </li>
        </div>
        </ul>
      
    </div>
  </nav>