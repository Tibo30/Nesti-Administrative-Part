<?php
include('app/config.php');

//auto loading classes
spl_autoload_register(function ($class) {
    $sources = array(PATH_MODEL . 'dao/' . $class . '.php', PATH_CTRL . $class . '.php ',  PATH_MODEL . 'entities/' . $class . '.php',PATH_MODEL . $class . '.php');
    foreach ($sources as $source) {
        if (file_exists($source)) {
            require_once $source;
        }
    }
});