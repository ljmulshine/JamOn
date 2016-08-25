<?php
    // configuration
    require("../includes/config.php");
    

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("joinGroup_template.php", ["title" => "Join Group"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   
         // get group name from form
         $groupName = $_POST["group"];
         
         // strip string of any trailing whitespace characters
         $groupName = rtrim($groupName, ' ');
        
         // make sure group name is not empty
         if(empty($groupName))
         {
             apologize("Invalid Group Name");
         }
        
         // check if groupName contains only letters numbers or spaces
         check($groupName);
         
         // create alternate group name so that it contains no spaces and thus can be used
         // in a SQL query
         $altGroup = altGroupName($groupName);

         // get username and id
         $userId = $_SESSION['soundCloudId'];
         $userName = $_SESSION['username'];
        
         // create variable to check it specified group exists
         $groupCheck = query("SELECT id FROM groups WHERE groupName = ?", $groupName);
         
         // check if specified group exists
         if (!$groupCheck)
         {
             apologize("Invalid group name");
         }
         
         // create variable to check if user has already joined group 
         $joinCheck = query("SELECT * FROM {$altGroup} WHERE username = '{$userName}'");
          
         // check if user has joined group already
         if ($joinCheck)
         {  
             apologize("You cannot join a group you've already joined!");
         }
         
         // call function in functions to create array with users' soundcloud song favorites
         $playlist = playlist();
         
         // check if user has Soundcloud favorites
         if(empty($playlist))
         {
             apologize("You cannot join a group if you have no Soundcloud favorites");
         }

         // insert user song preferences into group
         foreach($playlist as $song)
         {   
             query("INSERT INTO {$altGroup} (username, permalink) VALUES (?, ?)", $userName, $song['permalink_url']);
         }
         
         // keep track of groups the user is a part of in SQL table
         query("INSERT INTO userGroups (username, groupName) VALUES (?, ?)", $userName, $groupName);

         redirect("home.php");

    }
    
?>
