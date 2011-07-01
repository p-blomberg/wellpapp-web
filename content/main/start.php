<h1>Welcome to wellpapp-webb</h1>

<h2>Search for tag</h2>
<form action="/tag/name" method="get">
<fieldset>
<input type="text" name="name" />
<input type="submit" />
</fieldset>
</form>

<?php
echo "<h2>Your tags</h2>";
echo '<ul class="tagcloud">';
$tags=Tag::selection(null,null,"post_count DESC",64);

$max=0;
foreach($tags as $t) {
	if($t->post_count > $max)
		$max = $t->post_count;
}

function tagname_cmp($a,$b) {
	if($a->name == $b->name) {
		return 0;
	}
	return ($a->name < $b->name) ? -1 : 1;
}
usort($tags, "tagname_cmp");

foreach($tags as $t) {
	echo '<li style="font-size: '. intval(100 * ($t->post_count / $max)). 'px;">';
	echo "<a href=\"/tag/name/".urlencode($t->name)."\">
			".htmlspecialchars($t->name)."</a></li>\n";
}
echo "</ul>";
?>
