<?php
if (!isset($loc)) {
    $loc = "";
}

if (!@include(BASE_DIR.PATH_VIEW . "content/$loc" . "_content.php")) {
    include(BASE_DIR.PATH_ERRORS . 'error404.html');
}
