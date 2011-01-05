<h1>Welcome to wellpapp-webb</h1>

<h2>Your tags</h2>
<?php
$tags=Tag::selection();
foreach($tags as $t) {
	echo "<li><a href=\"/tag/name/".$t->name."\">".$t->name."</a></li>";
}
?>
