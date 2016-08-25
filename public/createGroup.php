<?php
     // configuration
    require("../includes/config.php");
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("createGroup_template.php", ["title" => "Preferences"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   
        // get group name from template
        $groupName = $_POST["group"];
        
        // get array of users souncloud favorite     
        $playlist = playlist();

        // check if user has Soundcloud favorites
        if(empty($playlist))
        {
            apologize("You cannot join a group if you have no Soundcloud favorites");
        }
        
        // strip string of any trailing whitespace characters
        $groupName = rtrim($groupName, ' ');
        
        // make sure group name is not empty
        if(empty($groupName))
        {
            apologize("Invalid Group Name");
        }
        
        // call function to check if inputted group name contains SQL Key Word
        check($groupName);
        
         // function call to change groupname
        $altGroup = altGroupName($groupName);
        
        // if query works, then group name already exists and true value is stored in $groupCheck
        $groupCheck = query("SELECT id FROM groups WHERE groupName = ?", $altGroup);
        
        // check if group name doesn't exist
        if ($groupCheck)
        {
            apologize("Group name already exists");
        }
        else
        {
             // create table in SQL
             query("CREATE TABLE IF NOT EXISTS `final`.`{$altGroup}` (
             `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
             `username` varchar(255) NOT NULL,
             `permalink` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
             ) ENGINE=InnoDB AUTO_INCREMENT=1;");

             // keep track of all existing groups in database
             query("INSERT INTO groups (groupName) VALUES (?)", $groupName);

             // get username and id
             $userId = $_SESSION['soundCloudId'];
             $userName = $_SESSION['username'];
             
             // insert user song preferences into group
             foreach($playlist as $song)
             {   
                 query("INSERT INTO {$altGroup} (username, permalink) VALUES (?, ?)", $userName, $song['permalink_url']);
             }
             
             // keep track of groups the user is a part of in SQL table
             query("INSERT INTO userGroups (username, groupName) VALUES (?, ?)", $userName, $groupName);
   
         }

         redirect("home.php"); 
    }
?>
