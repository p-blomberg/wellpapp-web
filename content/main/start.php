<h1>Welcome to wellpapp-webb</h1>

<h2>Search for tag</h2>
<form action="/tag/name" method="get">
<input type="text" name="name" />
<input type="submit" />
</form>

<h2>Your tags</h2>
<?php
$tags=Tag::selection();
foreach($tags as $t) {
	echo "<li><a href=\"/tag/name/".$t->name."\">".$t->name."</a></li>";
}
?>
