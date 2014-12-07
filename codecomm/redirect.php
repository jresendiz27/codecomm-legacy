<?php 
    function test_url_file($url) {
        $res = (($ftest = @fopen($url, ‘r’)) === false) ? false : @fclose($ftest);
        return ($res == TRUE) ? 1:0 ;
    }
    
    if (test_url_file(urlencode($_GET["url"]))) {
        header("Location: ".$_GET["url"]);
    }
    else {
        if (!preg_match("#[\w\W]*?://#i", $_GET["url"])) {
            header("Location: http://".$_GET["url"]);
        }
        else {
            header("Location: ".$_GET["url"]);
        }
    }

?>