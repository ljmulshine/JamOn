<?php

    /**
     * functions.php
     *
     * Liam Mulshine and Spencer Hallyburton
     * Some code inspired by CS50s, CS50 Finance Problem Set 7
     * Final Project
     *
     * Helper functions.
     */

    require_once("constants.php");

    /**
     * Apologizes to user with message.
     * Taken from CS50s, CS50 Finance Problem Set 
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
        exit;
    }

    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     * Taken from CS50s, CS50 Finance Problem Set
     */
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     * Taken from CS50s, CS50 Finance Problem Set
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     * Taken from CS50s, CS50 Finance Problem Set
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . "final" . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     *
     * Taken from CS50s, CS50 Finance Problem Set
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     *
     * Taken from CS50s, CS50 Finance Problem Set
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render template
            require("../templates/$template");

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }
    
   /** 
    *
    * Gets song favorites of user from soundcloud 
    *
    */
    function playlist()
    {
        // create client object with app credentials
        $client = new Services_Soundcloud('6adba59452a769c447fa24d030a99782', 'f2c4a2bb691a678ef69b724be8e7031a', 'http://final/index.php');
        
        // check if client was properly created 
        if (!$client)
        {
            print("Server Error");
            exit();
        }
        // inspired by http://stackoverflow.com/questions/11411076/sound-cloud-error
        try {
             // get access token for user
             $accessToken = $_SESSION['accessToken'];
            
             $userId = $_SESSION['soundCloudId'];
             $userName = $_SESSION['username'];
            
             // create array with users soundcloud song favorites
             $playlist = json_decode($client->get("users/{$userId}/favorites"), true);

         }   catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
             var_dump($e->getMessage());
             exit();
         }
         
         return $playlist;  
    }
    
   /** 
    * Check if inputted group name contains SQL Key Word or characters other 
    * than letters numbers and spaces 
    */
    function check($groupname)
    {
        // parse group name into separate words
        $groupParse = explode(' ', $groupname); 
       
        // check each word to see if it is a SQL Key Word
        foreach($groupParse as $word)       
        {
            // convert word to all uppercase
            $word = strtoupper($word);
            
            // check if word is in file sqlKeyWords.txt
            // if so, it is an invalid user name

                if (strpos(file_get_contents("../includes/sqlKeyWords.txt"), $word) !== FALSE || !ctype_alnum ($word))
                {
                    apologize("Invalid Group Name");
                }

        }
    }
    
   /**
    *
    * Change group name to a string that has no spaces so that query calls work correctly
    * 
    */
    function altGroupName($groupName)
    {
        // break group name into separate strings if
        $groups = explode(' ', $groupName);
        
        // altGroup will contain group name that is valid for SQL queries 
        $altGroup = '';
        
        // loop through each string from exploded string $groupName
        foreach($groups as $group)
        {
            // on first iteration
            if ($altGroup == '')
            {
                $altGroup = $group;  
            }  
            // on following iterations
            else
            {   
                // removes spaces from groupName
                $altGroup = $altGroup . $group;
            }
        }
        
        // return altGroup name
        return $altGroup;
    }

?>
