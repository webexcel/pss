<?php
function debug($a, $die = false) {
    if (is_string($a) || is_int($a)) {
        echo "<span style='color:#FF0000; font-weight:bold;'>ECHO : </span>";
		echo "<br /><br /><br />";
		echo $a . "<br />";
    } else {
		echo "<span style='color:#FF0000; font-weight:bold;'>ECHO : </span>";
		echo "<br /><br /><br />";
        echo "<pre>";
        print_r($a);
        echo "</pre>";
    }
	if($die) {
		echo "<br /><br /><br />";	
		die("<span style='color:#FF0000; font-weight:bold;'>debugging.............!</span>");
	}
}

function jslog($text) {
    echo "<script type='text/javascript'>";
    if (is_string($text) || is_int($text)) {
        echo "console.log('".$text."');";
		echo "\r \n";
    } 
    else {
        echo "console.log(JSON.stringify(".json_encode($text)."));";
		echo "\r \n";
    }
    echo "</script>";
}

?>