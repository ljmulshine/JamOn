<?php

    // configuration
    require("../includes/config.php"); 
    
   if ($_SERVER["REQUEST_METHOD"] == "GET")
    {  
        // create array with users soundcloud song favorites
        $playlist = playlist();
    }

    // render home page  
    render("home_template.php", ['title' => 'Home', 'playlist' => $playlist]);
    
?>
