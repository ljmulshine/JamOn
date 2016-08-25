<?php
    // code taken from CS50 Finance Problem Set 7
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check if username and password have been correcly inserted
        if (empty($_POST["username"]))
        {
            apologize("Please provide a username");
        }
        if (empty($_POST["password"]))
        {
            apologize("Please provide a password");
        }
        if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Password does not match confirmation password.");
        }
        
        // insert user into database
        $result = query("INSERT INTO users (username, hash) VALUES(?, ?)", $_POST["username"], crypt($_POST["password"]));
        
        // check if Insert ran correctly
        if($result === false)
        {
            apologize("Username already exists."); 
        }
        else
        {
            // get id of new user
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            $_SESSION = $id;

            //redirect to index.php
            redirect("index.php");
        }
    }

?>
