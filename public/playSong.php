<?php
       // configuration
    require("../includes/config.php");
    
    // else if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {  
        // define client so that you can use soundcloud api
        $client = new Services_Soundcloud('6adba59452a769c447fa24d030a99782', 'f2c4a2bb691a678ef69b724be8e7031a');
        
        // embed sound widget
        // https://developers.soundcloud.com/docs/api/guide#playing
        $client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));

        // get a tracks oembed data
        $track_url = $_POST['song'];

        $embed_info = json_decode($client->get('oembed', array('url' => $track_url)));

        render("playSong_template.php", ["embed_info" => $embed_info]);
         
    }
?>
