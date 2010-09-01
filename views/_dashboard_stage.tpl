<span class="small">Files staged for commit</span>
<?php

$del = array();

foreach($staged as $file)
{
	list($key, $path) = explode("\t", $file, 2);
	
	$state = git_state($key);
	
	switch( $state )
	{
		case 'new':
			$class = "green";
		break;
		case 'modified':
			$class = "orange";
			
			if( in_array($path, $del) )
			{
				continue 2;
			}
		break;
		case 'deleted':
			$class = "red";
			
			$del[] = $path;
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
