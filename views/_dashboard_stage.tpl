<span class="small">Files staged for commit</span>
<?php
foreach($staged as $file)
{
	list($state, $path) = explode("\t", $file, 2);
	
	switch( $state )
	{
		case '?':
			$class = "green";
		break;
		case 'M':
		case 'C':
			$class = "orange";
		break;
		case 'D':
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
<p class="small"><button class="small">Commit All</button>&nbsp;Key: <span class="green">New File</span> <span class="orange">Modified</span> <span class="red">Deleted</span></p>
