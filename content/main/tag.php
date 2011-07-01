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
	echo "<form action=\"/scripts/tag.php\" method=\"post\">";
	echo "<fieldset><legend>Tagggah!</legend>";
	echo "<input type=\"text\" name=\"tagname\" />";
	echo "<input type=\"submit\" value=\"taggaaaaaaahjhjhjh!\" />";
	echo "</fieldset>";
	foreach($tags as $tag) {
		echo "<h1>".$tag->name."</h1>";
		if(request_get("verbose")=="true") {
			echo "<p><a href=\"/tag/name/".$tag->name."?verbose=false\">Not So Verbose</a></p>";
		} else {
			echo "<p><a href=\"/tag/name/".$tag->name."?verbose=true\">Verbose</a></p>";
		}

		$posts=$tag->posts();
		foreach($posts as $post) {
			echo "<input type=\"checkbox\" name=\"".$post->md5."\" />";
			echo "<a href=\"". $wpc->image_prefix . $post->md5 .".". $post->ext ."\">";
			echo "<img src=\"" . $wpc->thumb_prefix . $post->md5 ."\" title=\"";
			foreach($post->tags as $t) {
				echo $t->name.' ';
			}
			echo "\" />\n";
			echo "</a>";
			if(request_get("verbose")=="true") {
				echo $post->md5;
			}
		}
	}
	echo "</form>";
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
