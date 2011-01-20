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
echo "<ul>";
$tags=Tag::selection();
foreach($tags as $t) {
	echo "<li><a href=\"/tag/name/".urlencode($t->name)."\">".htmlspecialchars($t->name)."</a></li>\n";
}
echo "</ul>";
?>
