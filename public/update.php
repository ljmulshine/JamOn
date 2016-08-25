<?php
     // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("update_template.php", ["title" => "Update"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   
        // create variable storing username
        $userName = $_SESSION["username"];
        
        // get user's soundcloud favorites
        $playlists = playlist();
        
        // check if user's soundcloud favorites were properly accessed
        if(!$playlists)
        {
            apologize("Souncloud error. Please try again.");
        }
        
        // create array containing the groups that a user is a part of
        $groups = query("SELECT groupName FROM userGroups WHERE username = ?", $userName);

        // loop through user's groups
        foreach($groups as $group)
        {
            $groupName = $group['groupName'];
            
            // create alternate group name to be used in SQL queries
            $groupName = altGroupName($groupName);
            
            // delete user's exising preferences in group
            query("DELETE FROM {$groupName} WHERE username = ?", $userName);
            
            // add users new preferences to group
            foreach($playlists as $song)
            {   
                query("INSERT INTO {$groupName} (username, permalink) VALUES (?, ?)", $userName, $song['permalink_url']);
            }
        }
        
        // redirect to myGroups
        redirect("myGroups.php");
        
    }    
    
?>
