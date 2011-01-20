<?php
require "../../includes.php";

$md5s=post_get_all();

$tagname=$md5s['tagname'];
unset($md5s['tagname']);
$tag=Tag::from_name($tagname);
var_dump($tag);

foreach($md5s as $md5 => $foobar) {
	$post=Post::from_md5($md5);
	$post->add_tag($tag);
}

echo "Thank you";

?>
