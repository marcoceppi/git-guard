<span class="small"><span style="small_link">New</span> | <span style="small_link">Modified</span> | <span style="small_link">Deleted</span> | <span style="small_link">All</span></span><br>
<?php
foreach($files as $file)
{
	list($state, $path) = explode(" ", $file, 2);
	switch( $state )
	{
		case '?':
			$class = "green";
		break;
		case 'C':
			$class = "red";
		break;
		default:
			$class = "";
		break;
	}
	
	?>
<span class="<?= $class; ?>"><input type="checkbox"> <?= truncate($path); ?></span><br>
	<?php
}
?>
