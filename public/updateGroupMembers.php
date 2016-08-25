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
        
        // create array that allows us to more easily access the users withina group
        $i=0;
        foreach ($groups as $group)
        {
            
            $groupName = $group['groupName'];
            
            $users = query("SELECT username FROM userGroups WHERE groupName = ?", $groupName);
            
            $groups[$i]['username'] = $users;
            $i++;
        }

        render("updateGroupMembers_template.php", ["title" => "Update Members", "groups" => $groups]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   
         // get user and group so that we can delete user from group
         $user = $_POST['user'];
         $group = $_POST['group'];
         
         // create alternate group name to be used in SQL queries
         $altGroup = altGroupName($group);        

         // create variable to check if user is part of group
         $userCheck = query("SELECT id FROM {$altGroup} WHERE username = ?", $user);
         
         // check for valid username
         if ($user == '' || $user == ' ' || !$userCheck)
         {
             apologize("Invalid username");
         }
         else
         {
             // remove user from group stored in sql table
             query("DELETE FROM {$altGroup} WHERE username = ?", $user);
             query("DELETE FROM userGroups WHERE username = ? AND groupName = ?", $user, $group);
         }
         
         redirect("updateGroupMembers.php");
         
    }
 
?>    
