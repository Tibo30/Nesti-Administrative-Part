<?php
if (!isset($url)) {
    $url="";
}
?>

<?php include(PATH_VIEW . 'common/head.php'); ?>

<body>
    <?php
    //echo "template / ";

    if ($url != 'connection') {
        include(PATH_VIEW . 'common/navigation.php');
    }
    if ($url == "recipe_edit" || $url == "recipe_add" || $url == "recipe_delete") {
        // echo "temp^late ";
    }
    //echo "template2 / ";
    if (isset($view)) {
        // echo " view la / ".$view->getFile()."/";
       
        include($view->getFile());
        //echo "view OK : ";
    } else {
        //error
    }
    //echo "template3 / ";
    //include(PATH_VIEW.'content/page_content.php');
    ?>


    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
    <script src="<?php echo BASE_URL ?>public/js/script.js"></script>
      <!-- Toast UI -->
    <script src="https://uicdn.toast.com/chart/latest/toastui-chart.min.js"></script>

</body>

</html>