<?
function clean_data($mixed) {
	if(is_array($mixed)) {
		foreach($mixed as $key => $value) {
			$mixed[$key] = clean_data($mixed[$key]);
		}
	} else {
		if(HTML_ACCESS) {
			$mixed = htmlspecialchars($mixed, ENT_QUOTES, 'utf-8');
		}
	}
	return $mixed;
}

function request_get($string) {
	if(isset($_REQUEST[$string])) {
		return clean_data($_REQUEST[$string]);
	}
	return false;
}
function post_get($string) {
	if(isset($_POST[$string])) {
		return clean_data($_POST[$string]);
	}
	return false;
}
function post_get_all() {
	$all=array();
	foreach($_POST as $key => $p) {
		$all[$key]=clean_data($p);
	}
	return $all;
}

function session_get($args) {
	if(!is_array($args)){
		$args = func_get_args();
	} 
	$ret = $_SESSION;
	foreach($args as $arg){
		if(!isset($ret[$arg])){
			return false;
		}
		$ret = $ret[$arg];
	}
	return clean_data($ret);
}

function session_set($string,$value) {
	$_SESSION[$string]=$value;
}

function cookie_set($name, $value) {
	// Expiry: 1 year
	$value = base64_encode($value);
	setcookie($name, $value, time()+31556926, '/');
}

function cookie_get($name) {
	if(isset($_COOKIE[$name])){
		return clean_data(base64_decode($_COOKIE[$name]));
	} else {
		return false;
	}
}
?>
