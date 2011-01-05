<?php
define("RANDOM_LOWERCASE", 1);
define("RANDOM_UPPERCASE", 2);
define("RANDOM_NUMERIC", 4);
define("RANDOM_SPECIAL", 8);
function get_random_string($length=10, $contents = 15) {
	$chars = '';
	if($contents & RANDOM_LOWERCASE) {
		$chars .= 'abcdefghijkmnpqrstuvwxyz';
	}
	if($contents & RANDOM_UPPERCASE) {
		$chars .= 'ABCDEFGHJKLMNPQRSTUVWXYZ';
	}
	if($contents & RANDOM_NUMERIC) {
		$chars .= '23456789';
	}
	if($contents & RANDOM_SPECIAL) {
		$chars .= '#¤%&/()=?.,;:*';
	}
	if(strlen($chars) == 0){
		throw new Exception("Unable to generate random string with no allowed chars.");
	}
	$result = '';
	for(; $length; --$length) {
		$result .= $chars[rand(0, strlen($chars)-1)];
	}
	return $result;
}
?>
