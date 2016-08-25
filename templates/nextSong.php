<?php

    // configuration
    require("../includes/config.php");
    
    // else if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {  
        // get group that user wants to play music from
        $group = $_POST["group"];
    }
    
    ?>    
