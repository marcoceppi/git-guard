<span class="small">Files staged for commit</span>
<?php
foreach($staged as $file)
{
	list($state, $path) = explode("\t", $file, 2);
	
	switch( $state )
	{
		case '?':
		case 'N':
			$class = "green";
		break;
		case 'M':
		case 'C':
			$class = "orange";
		break;
		case 'D':
		case 'R':
			$class = "red";
		break;
		default:
			$class = "";
		break;
	}
	
	?>
<p class="simple <?= $class; ?>">&nbsp;&nbsp;<?= truncate($path, 60); ?></p> 
	<?php
}
?>
<p class="small"><button class="small" onClick="execute_action('commitall');">Commit All</button>&nbsp;Key: <span class="green">New File</span> <span class="orange">Modified</span> <span class="red">Deleted</span></p>
