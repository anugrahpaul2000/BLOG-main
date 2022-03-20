<?php

    use libraries\Core;

    session_start();
    require_once ("../app/config/config.php");
    require_once ("../app/libraries/Core.php");
    require_once("../app/libraries/Controller.php");
    require_once("../app/libraries/Database.php");
    require_once("../app/init.php");
    // require_once("../app/sessionRedirect.php");

    //Initiate Core Class
    $init = new Core();
