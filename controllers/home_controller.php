<?php
$error;

$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
if($url){
    $shortUrl = makeShortUrl();

    if(userConnected()){
        try{
            $urlAdded = $bdd->addUrl($url, $shortUrl[1], 1);
            if($urlAdded){
                $newShortUrl = $shortUrl[0];
            }
            else{
                $error = "Url not added";
            }
        }
        catch(PDOException $e){
            $error = $e->getMessage();
        }
    }
    else{
        $urlAdded = $bdd->addUrl($url, $shortUrl, "test");
        if($urlAdded){
            $newShortUrl = $shortUrl;
            echo $newShortUrl;
        }
        else{
            $error = "Url not added";
        }
    }
}
