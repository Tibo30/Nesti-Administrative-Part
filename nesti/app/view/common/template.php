<html>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(PATH_VIEW.'common/head.php'); ?>

</head>

<body>
    <?php 
     if ($loc !='connection'){
        include(PATH_VIEW.'common/header.php');
        include(PATH_VIEW.'common/navigation.php');
    }
    include(PATH_VIEW.'content/page_content.php'); 
    //   $query->disconnect();?>
  

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="public/js/script.js"></script>

</body>

</html>