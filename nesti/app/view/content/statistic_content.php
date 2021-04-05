<?php if (array_search("admin", $_SESSION["roles"]) === false) {

?>
    <div class="container">
        <h2 class="titleAccessForbidden">Access forbidden</h2>
        <p class="textAccessForbidden">You don't have the rights to access this page</p>
    </div>
<?php } else { ?>
    <h1>Stats</h1>

<?php } ?>