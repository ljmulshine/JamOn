<?php

    /**
     * config.php
     *
     * Liam Mulshine and Spencer Hallyburton
     * Most code on this file taken from CS50s CS50 Finance Problem Set 7
     * Final Project
     *
     * Configures pages.
     */

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("constants.php");
    require("functions.php");
    require("php-soundcloud/Services/Soundcloud.php");
    

    // enable sessions
    session_start();
        
    // require authentication for all pages except /login.php, /logout.php, and /register.php
    if (!in_array($_SERVER["PHP_SELF"], ["/login.php", "/logout.php", "/register.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }
    
?>
