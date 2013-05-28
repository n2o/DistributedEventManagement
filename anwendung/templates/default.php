<?php
foreach($this->_['entries'] as $entry) {
?>
	<article>
		<header>
			<h2><a href="?view=entry&id=<?php echo $entry['id'] ?>"><?php echo $entry['title']; ?></a></h2>
		</header>
		<p><?php echo $entry['content']; ?></p>
	</article>
<?php
}
?>