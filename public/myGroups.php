<?php
     // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // create variable storing username
        $userName = $_SESSION["username"];
        
        // create array containing the groups that a user is a part of
        $groups = query("SELECT groupName FROM userGroups WHERE username = ?", $userName);
        
        // else render form
        render("myGroups_template.php", ["title" => "My Groups", "groups" => $groups]);
    }  
?>
