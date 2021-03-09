<?php
if (!isset($url)) {
    $url="";
}
?>

<nav class="navbar navbar-expand-xl bg-light p-0" id="mainNav">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars" style="color:#005662; font-size:20px;"></i>
  </button>

  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav mr-auto navnesti justify-content-around">
      <li class="nav-item m-xl-3 <?= ($url == 'recipe'||$url == 'recipe_add'||$url == 'recipe_edit'||$url == 'recipe_delete') ? 'active' : ''; ?>">
      <!--<button class="btnnav"></button> -->
        <a class="nav-link " href="<?= BASE_URL ?>recipe">
          <i class="fas fa-clipboard-list mr-2"></i>
          Recipes</a>
      </li>
      <li class="nav-item m-xl-3 <?= ($url == 'article'||$url == 'article_add'||$url == 'article_orders') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= BASE_URL ?>article">
          <i class="fas fa-utensils mr-2"></i>
          Articles</a>
      </li>
      <li class="nav-item m-xl-3 <?= ($url == 'user') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= BASE_URL ?>user">
          <i class="fas fa-user mr-2"></i>
          Users</a>
      </li>
      <li class="nav-item m-xl-3 <?= ($url == 'statistic') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= BASE_URL ?>statistic">
          <i class="fas fa-chart-bar mr-2"></i>
          Statistics
        </a>
      </li>
    </ul>
    <form class="form-inline logOut my-2 my-lg-0 justify-content-around">
      <a class="nav-link" href="">
        <i class="fas fa-user mr-2"></i>
        <?php echo $_SESSION["lastname"] . " " . $_SESSION["firstname"] ?>
      </a>
      <a class="nav-link" href="<?= BASE_URL ?>disconnection">
        <i class="fas fa-sign-out-alt mr-2"></i>
        Log Out</a>
    </form>
  </div>



</nav>