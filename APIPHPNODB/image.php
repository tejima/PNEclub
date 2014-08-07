<?php
echo img_src4screen_name($_GET['screen_name']);

function img_src4screen_name($screen_name){
    $handle = fopen("https://twitter.com/". $_GET['screen_name'], "r");
    $result = false;
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            if(preg_match('/ProfileAvatar-image.*?src="(.*?)"/',$buffer,$matches)){
                $result = $matches[1];
                break;
            }
        }
    }
    fclose($handle);
    return $result;
}
