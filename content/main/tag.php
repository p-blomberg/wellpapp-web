<?php
if(count($request)<2) {
	die("Bad request");
}
$method=array_shift($request);
$data=array_shift($request);
$tags=Tag::selection($method,$data);
foreach($tags as $tag) {
	echo "<h1>".$tag->name."</h1>";
}
?>
