<?php

    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('P_ROOT') ? null : define('P_ROOT', dirname($_SERVER['PHP_SELF'], 3));

    require_once 'functionsandglobals.php';
    // require_once 'class.mypdo.php';
    require_once 'class.dbobject.php';
    require_once 'class.setter.php';
    require_once 'class.dummy.php';
    require_once 'class.game.php';
?>
