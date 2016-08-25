<?php

    // configuration
    require("../includes/config.php");
    
    // else if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {  
        // get group that user wants to play music from
        $group = $_POST["group"];
        
        // change groupname to valid SQL table name
        $altGroup = altGroupName($group);
        
        // check if there are any songs in SQL table
        $songLinkCheck = query("SELECT permalink FROM {$altGroup}");
        
        // if there are non, apologize
        if(!$songLinkCheck)
        {
            apologize("No songs in Group!");
        }
        
        // get a random song link from group in SQL
        $songLink = query("SELECT permalink FROM {$altGroup} ORDER BY RAND() LIMIT 1");
        
        // check if next song is the same as the last song played
        if(empty($_SESSION['lastSongPlayed']))
        {
            // store last song played ing SESSION
            $_SESSION['lastSongPlayed'] = $songLink;
        }
        else
        {
            // choose a new song until selected song is not the same as song previously played
            while($_SESSION['lastSongPlayed'] == $songLink)
            {
                // get a random song link from group in SQL
                $songLink = query("SELECT permalink FROM {$altGroup} ORDER BY RAND() LIMIT 1");
            }
            
            // store last song played ing SESSION
            $_SESSION['lastSongPlayed'] = $songLink;
        }

        // define client so that you can use soundcloud api
        $client = new Services_Soundcloud('6adba59452a769c447fa24d030a99782', 'f2c4a2bb691a678ef69b724be8e7031a');
        
        // embed sound widget
        // https://developers.soundcloud.com/docs/api/guide#playing
        $client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));        
        
        // get a tracks oembed data 
        $track_url = $songLink[0]["permalink"];
        $embed_info = json_decode($client->get('oembed', array('url' => $track_url)));

        render("play_template.php", ["embed_info" => $embed_info, "group" => $group]);
         
    }
?>
