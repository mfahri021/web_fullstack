<?php

$_list_category = ["NC", "classic", "puzzle", "race", "action"];

function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i'     => 'iPhone',
        '/ipod/i'       => 'iPod',
        '/ipad/i'       => 'iPad',
        '/android/i'    => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i'      => 'Mobile'
    );

    // return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    // otherwise
    return false;
}

?>
