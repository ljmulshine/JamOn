<?php

    // configuration
    require("../includes/config.php"); 

    // check if user has connected to soundcloud
    if($_GET['code'] == NULL)
    {
        redirect('connect.php');
    }     
    else if ($_SERVER["REQUEST_METHOD"] == "GET")
    {  
        // create client object with app credentials
        $client = new Services_Soundcloud('6adba59452a769c447fa24d030a99782', 'f2c4a2bb691a678ef69b724be8e7031a', 'http://final/index.php');
        
        // verify that we are able to access Soundcloud account
        if (!$client)
        {
            print("Server Error");
            exit();
        }
        // inspired by http://stackoverflow.com/questions/11411076/sound-cloud-error
        try {
            // get access token for user
            $accessToken = $client->accessToken($_GET['code']);

            // create associative array with infomation about the user
            // including user id
            $me = json_decode($client->get('me'), true);
            $userId = $me["id"];
            $userName = $me["username"];

            // store soundcloud user Id in Session
            $_SESSION["soundCloudId"] = $userId; 
            $_SESSION["username"] = $userName;
            
            // check if access token was properly retrieved 
            if ($accessToken)
            {   
                // store non-expiring token in Session
                $_SESSION["accessToken"] = $accessToken;
            }
            else
            {
                print("Server Error");
                exit();
            } 
            
            // create array with users soundcloud song favorites
            $playlist = playlist();   

        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            var_dump($e->getMessage());
            exit();
        }
    }
        
    render("home_template.php", ['title' => 'Home', 'playlist' => $playlist]);
    
?>
