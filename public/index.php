<?
define("HTML_ACCESS", true);
require "../includes.php";

// Prepare path
$path_info=isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'';
$untouched_request=$path_info;
$request=explode('/',$path_info);
array_shift($request);
$main=array_shift($request);
if(is_dir("../content/main/$main") && count($request) > 0) {
	$main_dir = $main.'/';
	$main = array_shift($request);
} else {
	$main_dir = '';
}
$simple_main=$main;
if($main == '') {
	$main = $application['default_content'];
}
$main="../content/main/".$main_dir.basename($main).".php";
if($main == '' || !file_exists($main)) {
	$main_404=$main;
	$main="../content/main/404.php";
}
?>
<?="<?xml version=\"1.0\" encoding=\"utf-8\"?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?=$application['name']?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="<?=absolute_path('style.css'); ?>" />
	</head>
	<body>
		<div id="wrapper">
			<div id="main_inner_wrapper">
				<?require $main?>
			</div>
		</div>
	</body>
</html>

