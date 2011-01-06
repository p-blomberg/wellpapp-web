<?php
if(count($request)<1) {
	die("Bad request");
}
$method=array_shift($request);
if(count($request)<1 && request_get("name")) {
	$data=request_get("name");
} else {
	$data=array_shift($request);
}
$tags=Tag::selection($method,$data);
if(count($tags)>0) {
	foreach($tags as $tag) {
		echo "<h1>".$tag->name."</h1>";

		$posts=$tag->posts();
		foreach($posts as $post) {
			echo $post->md5;
		}

	}
} else {
	?>
	<h1>Sorry, no hits.</h1>
	<h2>Try again?</h2>
	<form action="/tag/name" method="get">
	<input type="text" name="name" value="<?=request_get("name")?>" />
	<input type="submit" />
	</form>
	<?
}
?>
