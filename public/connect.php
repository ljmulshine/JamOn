<?php

    require("../includes/config.php");
   
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
            // https://developers.soundcloud.com/docs/api/guide
            // create client object with app credentials
            $client = new Services_Soundcloud(
            '6adba59452a769c447fa24d030a99782', 'f2c4a2bb691a678ef69b724be8e7031a', 'http://final/index.php');
            
            // redirect user to authorize URL
            header("Location: " . $client->getAuthorizeUrl(array('scope'=>'non-expiring')));
    }      
?>
